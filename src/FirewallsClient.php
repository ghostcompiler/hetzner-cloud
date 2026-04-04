<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#firewalls
 */
final class FirewallsClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listFirewalls(array $query = []): array
    {
        return $this->get('firewalls', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createFirewall(array $body): array
    {
        return $this->post('firewalls', $body);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listFirewallsActions(array $query = []): array
    {
        return $this->get('firewalls/actions', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getFirewallsAction(int|string $id): array
    {
        return $this->get('firewalls/actions/' . $id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getFirewall(int|string $id): array
    {
        return $this->get('firewalls/' . $id);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateFirewall(int|string $id, array $body): array
    {
        return $this->put('firewalls/' . $id, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deleteFirewall(int|string $id): array
    {
        return $this->delete('firewalls/' . $id);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listFirewallActions(int|string $id, array $query = []): array
    {
        return $this->get('firewalls/' . $id . '/actions', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function applyFirewallToResources(int|string $id, array $body): array
    {
        return $this->post('firewalls/' . $id . '/actions/apply_to_resources', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function removeFirewallFromResources(int|string $id, array $body): array
    {
        return $this->post('firewalls/' . $id . '/actions/remove_from_resources', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function setFirewallRules(int|string $id, array $body): array
    {
        return $this->post('firewalls/' . $id . '/actions/set_rules', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function getFirewallAction(int|string $id, int|string $actionId): array
    {
        return $this->get('firewalls/' . $id . '/actions/' . $actionId);
    }
}
