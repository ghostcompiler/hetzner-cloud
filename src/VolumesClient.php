<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#volumes
 */
final class VolumesClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listVolumes(array $query = []): array
    {
        return $this->get('volumes', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createVolume(array $body): array
    {
        return $this->post('volumes', $body);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listVolumesActions(array $query = []): array
    {
        return $this->get('volumes/actions', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getVolumesAction(int|string $id): array
    {
        return $this->get('volumes/actions/' . $id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getVolume(int|string $id): array
    {
        return $this->get('volumes/' . $id);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateVolume(int|string $id, array $body): array
    {
        return $this->put('volumes/' . $id, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deleteVolume(int|string $id): array
    {
        return $this->delete('volumes/' . $id);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listVolumeActions(int|string $id, array $query = []): array
    {
        return $this->get('volumes/' . $id . '/actions', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function attachVolume(int|string $id, array $body): array
    {
        return $this->post('volumes/' . $id . '/actions/attach', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeVolumeProtection(int|string $id, array $body): array
    {
        return $this->post('volumes/' . $id . '/actions/change_protection', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function detachVolume(int|string $id): array
    {
        return $this->post('volumes/' . $id . '/actions/detach', (object) []);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function resizeVolume(int|string $id, array $body): array
    {
        return $this->post('volumes/' . $id . '/actions/resize', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function getVolumeAction(int|string $id, int|string $actionId): array
    {
        return $this->get('volumes/' . $id . '/actions/' . $actionId);
    }
}
