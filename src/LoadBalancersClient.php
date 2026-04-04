<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#load-balancers
 */
final class LoadBalancersClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listLoadBalancers(array $query = []): array
    {
        return $this->get('load_balancers', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createLoadBalancer(array $body): array
    {
        return $this->post('load_balancers', $body);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listLoadBalancersActions(array $query = []): array
    {
        return $this->get('load_balancers/actions', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getLoadBalancersAction(int|string $id): array
    {
        return $this->get('load_balancers/actions/' . $id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getLoadBalancer(int|string $id): array
    {
        return $this->get('load_balancers/' . $id);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateLoadBalancer(int|string $id, array $body): array
    {
        return $this->put('load_balancers/' . $id, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deleteLoadBalancer(int|string $id): array
    {
        return $this->delete('load_balancers/' . $id);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listLoadBalancerActions(int|string $id, array $query = []): array
    {
        return $this->get('load_balancers/' . $id . '/actions', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function addLoadBalancerService(int|string $id, array $body): array
    {
        return $this->post('load_balancers/' . $id . '/actions/add_service', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function addLoadBalancerTarget(int|string $id, array $body): array
    {
        return $this->post('load_balancers/' . $id . '/actions/add_target', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function attachLoadBalancerToNetwork(int|string $id, array $body): array
    {
        return $this->post('load_balancers/' . $id . '/actions/attach_to_network', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeLoadBalancerAlgorithm(int|string $id, array $body): array
    {
        return $this->post('load_balancers/' . $id . '/actions/change_algorithm', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeLoadBalancerDnsPtr(int|string $id, array $body): array
    {
        return $this->post('load_balancers/' . $id . '/actions/change_dns_ptr', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeLoadBalancerProtection(int|string $id, array $body): array
    {
        return $this->post('load_balancers/' . $id . '/actions/change_protection', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeLoadBalancerType(int|string $id, array $body): array
    {
        return $this->post('load_balancers/' . $id . '/actions/change_type', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function deleteLoadBalancerService(int|string $id, array $body): array
    {
        return $this->post('load_balancers/' . $id . '/actions/delete_service', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function detachLoadBalancerFromNetwork(int|string $id, array $body): array
    {
        return $this->post('load_balancers/' . $id . '/actions/detach_from_network', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function disableLoadBalancerPublicInterface(int|string $id): array
    {
        return $this->post('load_balancers/' . $id . '/actions/disable_public_interface', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function enableLoadBalancerPublicInterface(int|string $id): array
    {
        return $this->post('load_balancers/' . $id . '/actions/enable_public_interface', (object) []);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function removeLoadBalancerTarget(int|string $id, array $body): array
    {
        return $this->post('load_balancers/' . $id . '/actions/remove_target', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateLoadBalancerService(int|string $id, array $body): array
    {
        return $this->post('load_balancers/' . $id . '/actions/update_service', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function getLoadBalancerAction(int|string $id, int|string $actionId): array
    {
        return $this->get('load_balancers/' . $id . '/actions/' . $actionId);
    }

    /**
     * @param array<string, mixed> $query e.g. type, start, end
     * @return array<string, mixed>
     */
    public function getLoadBalancerMetrics(int|string $id, array $query): array
    {
        return $this->get('load_balancers/' . $id . '/metrics', $query);
    }
}
