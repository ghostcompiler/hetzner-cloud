<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#locations
 */
final class LocationsClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listLocations(array $query = []): array
    {
        return $this->get('locations', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getLocation(int|string $id): array
    {
        return $this->get('locations/' . $id);
    }
}
