<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

use Ghostcompiler\Hetzner\Http\CurlTransport;

abstract class AbstractResourceClient
{
    public function __construct(protected readonly CurlTransport $http)
    {
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    protected function get(string $path, array $query = []): array
    {
        return $this->http->request('GET', $path, $query)->getData();
    }

    /**
     * @param array<string, mixed>|\stdClass $body JSON object or array (use `(object)[]` for `{}`)
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    protected function post(string $path, array|\stdClass $body, array $query = []): array
    {
        return $this->http->request('POST', $path, $query, $body)->getData();
    }

    /**
     * @param array<string, mixed>|\stdClass $body
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    protected function put(string $path, array|\stdClass $body, array $query = []): array
    {
        return $this->http->request('PUT', $path, $query, $body)->getData();
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    protected function delete(string $path, array $query = []): array
    {
        return $this->http->request('DELETE', $path, $query, null)->getData();
    }

    protected static function encodePathSegment(string $segment): string
    {
        return rawurlencode($segment);
    }
}
