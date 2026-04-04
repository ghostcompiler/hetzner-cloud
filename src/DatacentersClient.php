<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#datacenters
 */
final class DatacentersClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listDatacenters(array $query = []): array
    {
        return $this->get('datacenters', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getDatacenter(int|string $id): array
    {
        return $this->get('datacenters/' . $id);
    }
}
