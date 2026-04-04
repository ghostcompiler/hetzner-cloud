<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#load-balancer-types
 */
final class LoadBalancerTypesClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listLoadBalancerTypes(array $query = []): array
    {
        return $this->get('load_balancer_types', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getLoadBalancerType(int|string $id): array
    {
        return $this->get('load_balancer_types/' . $id);
    }
}
