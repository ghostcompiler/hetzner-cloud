<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#pricing
 */
final class PricingClient extends AbstractResourceClient
{
    /**
     * @return array<string, mixed>
     */
    public function getPricing(): array
    {
        return $this->get('pricing');
    }
}
