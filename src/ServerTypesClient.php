<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#server-types
 */
final class ServerTypesClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listServerTypes(array $query = []): array
    {
        return $this->get('server_types', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getServerType(int|string $id): array
    {
        return $this->get('server_types/' . $id);
    }
}
