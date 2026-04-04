<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#placement-groups
 */
final class PlacementGroupsClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPlacementGroups(array $query = []): array
    {
        return $this->get('placement_groups', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createPlacementGroup(array $body): array
    {
        return $this->post('placement_groups', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function getPlacementGroup(int|string $id): array
    {
        return $this->get('placement_groups/' . $id);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updatePlacementGroup(int|string $id, array $body): array
    {
        return $this->put('placement_groups/' . $id, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deletePlacementGroup(int|string $id): array
    {
        return $this->delete('placement_groups/' . $id);
    }
}
