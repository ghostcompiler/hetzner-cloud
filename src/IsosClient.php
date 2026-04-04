<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#isos
 */
final class IsosClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listIsos(array $query = []): array
    {
        return $this->get('isos', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getIso(int|string $id): array
    {
        return $this->get('isos/' . $id);
    }
}
