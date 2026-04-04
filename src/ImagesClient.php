<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#images
 */
final class ImagesClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listImages(array $query = []): array
    {
        return $this->get('images', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listImagesActions(array $query = []): array
    {
        return $this->get('images/actions', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getImagesAction(int|string $id): array
    {
        return $this->get('images/actions/' . $id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getImage(int|string $id): array
    {
        return $this->get('images/' . $id);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateImage(int|string $id, array $body): array
    {
        return $this->put('images/' . $id, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deleteImage(int|string $id): array
    {
        return $this->delete('images/' . $id);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listImageActions(int|string $id, array $query = []): array
    {
        return $this->get('images/' . $id . '/actions', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeImageProtection(int|string $id, array $body): array
    {
        return $this->post('images/' . $id . '/actions/change_protection', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function getImageAction(int|string $id, int|string $actionId): array
    {
        return $this->get('images/' . $id . '/actions/' . $actionId);
    }
}
