<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * Result of a successful HTTP call (2xx) with a JSON body.
 */
final class ApiResponse
{
    /**
     * @param array<string, mixed> $data Decoded JSON object (empty array if body empty)
     * @param array<string, string> $headers Lowercase header name => value (last value if repeated)
     */
    public function __construct(
        private readonly int $statusCode,
        private readonly array $data,
        private readonly array $headers,
        private readonly string $rawBody,
    ) {
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getRawBody(): string
    {
        return $this->rawBody;
    }

    public function getHeader(string $name): ?string
    {
        $key = strtolower($name);

        return $this->headers[$key] ?? null;
    }
}
