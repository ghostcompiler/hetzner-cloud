<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#floating-ips
 */
final class FloatingIpsClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listFloatingIps(array $query = []): array
    {
        return $this->get('floating_ips', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createFloatingIp(array $body): array
    {
        return $this->post('floating_ips', $body);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listFloatingIpsActions(array $query = []): array
    {
        return $this->get('floating_ips/actions', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getFloatingIpsAction(int|string $id): array
    {
        return $this->get('floating_ips/actions/' . $id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getFloatingIp(int|string $id): array
    {
        return $this->get('floating_ips/' . $id);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateFloatingIp(int|string $id, array $body): array
    {
        return $this->put('floating_ips/' . $id, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deleteFloatingIp(int|string $id): array
    {
        return $this->delete('floating_ips/' . $id);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listFloatingIpActions(int|string $id, array $query = []): array
    {
        return $this->get('floating_ips/' . $id . '/actions', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function assignFloatingIp(int|string $id, array $body): array
    {
        return $this->post('floating_ips/' . $id . '/actions/assign', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeFloatingIpDnsPtr(int|string $id, array $body): array
    {
        return $this->post('floating_ips/' . $id . '/actions/change_dns_ptr', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeFloatingIpProtection(int|string $id, array $body): array
    {
        return $this->post('floating_ips/' . $id . '/actions/change_protection', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function unassignFloatingIp(int|string $id): array
    {
        return $this->post('floating_ips/' . $id . '/actions/unassign', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function getFloatingIpAction(int|string $id, int|string $actionId): array
    {
        return $this->get('floating_ips/' . $id . '/actions/' . $actionId);
    }
}
