<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#networks
 */
final class NetworksClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listNetworks(array $query = []): array
    {
        return $this->get('networks', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createNetwork(array $body): array
    {
        return $this->post('networks', $body);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listNetworksActions(array $query = []): array
    {
        return $this->get('networks/actions', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getNetworksAction(int|string $id): array
    {
        return $this->get('networks/actions/' . $id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getNetwork(int|string $id): array
    {
        return $this->get('networks/' . $id);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateNetwork(int|string $id, array $body): array
    {
        return $this->put('networks/' . $id, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deleteNetwork(int|string $id): array
    {
        return $this->delete('networks/' . $id);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listNetworkActions(int|string $id, array $query = []): array
    {
        return $this->get('networks/' . $id . '/actions', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function addNetworkRoute(int|string $id, array $body): array
    {
        return $this->post('networks/' . $id . '/actions/add_route', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function addNetworkSubnet(int|string $id, array $body): array
    {
        return $this->post('networks/' . $id . '/actions/add_subnet', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeNetworkIpRange(int|string $id, array $body): array
    {
        return $this->post('networks/' . $id . '/actions/change_ip_range', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeNetworkProtection(int|string $id, array $body): array
    {
        return $this->post('networks/' . $id . '/actions/change_protection', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function deleteNetworkRoute(int|string $id, array $body): array
    {
        return $this->post('networks/' . $id . '/actions/delete_route', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function deleteNetworkSubnet(int|string $id, array $body): array
    {
        return $this->post('networks/' . $id . '/actions/delete_subnet', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function getNetworkAction(int|string $id, int|string $actionId): array
    {
        return $this->get('networks/' . $id . '/actions/' . $actionId);
    }
}
