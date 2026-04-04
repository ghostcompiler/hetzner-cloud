<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#primary-ips
 */
final class PrimaryIpsClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPrimaryIps(array $query = []): array
    {
        return $this->get('primary_ips', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createPrimaryIp(array $body): array
    {
        return $this->post('primary_ips', $body);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPrimaryIpsActions(array $query = []): array
    {
        return $this->get('primary_ips/actions', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getPrimaryIpsAction(int|string $id): array
    {
        return $this->get('primary_ips/actions/' . $id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getPrimaryIp(int|string $id): array
    {
        return $this->get('primary_ips/' . $id);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updatePrimaryIp(int|string $id, array $body): array
    {
        return $this->put('primary_ips/' . $id, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deletePrimaryIp(int|string $id): array
    {
        return $this->delete('primary_ips/' . $id);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPrimaryIpActions(int|string $id, array $query = []): array
    {
        return $this->get('primary_ips/' . $id . '/actions', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function assignPrimaryIp(int|string $id, array $body): array
    {
        return $this->post('primary_ips/' . $id . '/actions/assign', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changePrimaryIpDnsPtr(int|string $id, array $body): array
    {
        return $this->post('primary_ips/' . $id . '/actions/change_dns_ptr', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changePrimaryIpProtection(int|string $id, array $body): array
    {
        return $this->post('primary_ips/' . $id . '/actions/change_protection', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function unassignPrimaryIp(int|string $id): array
    {
        return $this->post('primary_ips/' . $id . '/actions/unassign', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function getPrimaryIpAction(int|string $id, int|string $actionId): array
    {
        return $this->get('primary_ips/' . $id . '/actions/' . $actionId);
    }
}
