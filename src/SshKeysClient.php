<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#ssh-keys
 */
final class SshKeysClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listSshKeys(array $query = []): array
    {
        return $this->get('ssh_keys', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createSshKey(array $body): array
    {
        return $this->post('ssh_keys', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function getSshKey(int|string $id): array
    {
        return $this->get('ssh_keys/' . $id);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateSshKey(int|string $id, array $body): array
    {
        return $this->put('ssh_keys/' . $id, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deleteSshKey(int|string $id): array
    {
        return $this->delete('ssh_keys/' . $id);
    }
}
