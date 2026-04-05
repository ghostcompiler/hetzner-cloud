<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner\Http;

use Ghostcompiler\Hetzner\ApiException;
use Ghostcompiler\Hetzner\ApiResponse;

/**
 * HTTP layer using ext-curl only (no PECL http, streams, or third-party clients).
 */
final class CurlTransport
{
    private const DEFAULT_BASE = 'https://api.hetzner.cloud/v1';

    public function __construct(
        private readonly string $token,
        private readonly string $baseUrl = self::DEFAULT_BASE,
    ) {
    }

    /**
     * @param array<string, mixed> $query Query parameters; array values become repeated keys (e.g. id=1&id=2)
     * @param array<string, mixed>|\stdClass|null $body JSON for POST/PUT/PATCH; null means no body
     */
    public function request(string $method, string $path, array $query = [], array|\stdClass|null $body = null): ApiResponse
    {
        $method = strtoupper($method);
        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($path, '/');
        $qs = $this->buildQueryString($query);
        if ($qs !== '') {
            $url .= '?' . $qs;
        }

        $ch = curl_init($url);
        if ($ch === false) {
            throw new ApiException('curl_init failed', 0);
        }

        $headers = [
            'Authorization: Bearer ' . $this->token,
            'Accept: application/json',
        ];

        if ($body !== null && in_array($method, ['POST', 'PUT', 'PATCH'], true)) {
            $headers[] = 'Content-Type: application/json';
            $payload = json_encode($body, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }

        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_USERAGENT => 'ghostcompiler-hetzner-php/1.0',
        ]);

        $raw = curl_exec($ch);
        if ($raw === false) {
            $err = curl_error($ch);
            $this->closeCurlIfNeeded($ch);
            throw new ApiException('cURL error: ' . $err, 0);
        }

        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = (int) curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $this->closeCurlIfNeeded($ch);

        $headerBlock = substr($raw, 0, $headerSize);
        $responseBody = substr($raw, $headerSize);
        $parsedHeaders = $this->parseHeaders($headerBlock);

        $data = [];
        $trimmed = trim($responseBody);
        if ($trimmed !== '') {
            try {
                $decoded = json_decode($trimmed, true, 512, JSON_THROW_ON_ERROR);
                $data = is_array($decoded) ? $decoded : [];
            } catch (\JsonException) {
                throw new ApiException('Invalid JSON in response body', $status, null, $parsedHeaders);
            }
        }

        if ($status < 200 || $status >= 300) {
            $apiErr = isset($data['error']) && is_array($data['error']) ? $data['error'] : null;
            $msg = $apiErr['message'] ?? ('HTTP ' . $status);
            if (! is_string($msg)) {
                $msg = 'HTTP ' . $status;
            }
            throw new ApiException($msg, $status, $apiErr, $parsedHeaders);
        }

        return new ApiResponse($status, $data, $parsedHeaders, $responseBody);
    }

    /**
     * @param array<string, mixed> $query
     */
    private function buildQueryString(array $query): string
    {
        $pairs = [];
        foreach ($query as $key => $value) {
            $k = (string) $key;
            if (is_array($value)) {
                foreach ($value as $item) {
                    $pairs[] = rawurlencode($k) . '=' . rawurlencode((string) $item);
                }
            } else {
                $pairs[] = rawurlencode($k) . '=' . rawurlencode((string) $value);
            }
        }

        return implode('&', $pairs);
    }

    /**
     * PHP 8.0+ uses CurlHandle objects that are released when out of scope; curl_close() is a no-op
     * and is deprecated in PHP 8.5+. PHP 7.x still uses resources and should be closed explicitly.
     *
     * @param resource|\CurlHandle $ch
     */
    private function closeCurlIfNeeded($ch): void
    {
        if (\PHP_VERSION_ID < 80000) {
            curl_close($ch);
        }
    }

    /**
     * @return array<string, string>
     */
    private function parseHeaders(string $raw): array
    {
        $out = [];
        $lines = preg_split("/\r\n|\n|\r/", $raw) ?: [];
        foreach ($lines as $line) {
            if (str_contains($line, ':')) {
                [$name, $value] = explode(':', $line, 2);
                $out[strtolower(trim($name))] = trim($value);
            }
        }

        return $out;
    }
}
