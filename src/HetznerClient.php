<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

use Ghostcompiler\Hetzner\Http\CurlTransport;

/**
 * Facade for the Hetzner Cloud API (https://api.hetzner.cloud/v1).
 *
 * @see https://docs.hetzner.cloud/reference/cloud
 */
final class HetznerClient
{
    public readonly ActionsClient $actions;

    public readonly CertificatesClient $certificates;

    public readonly DatacentersClient $datacenters;

    public readonly FirewallsClient $firewalls;

    public readonly FloatingIpsClient $floatingIps;

    public readonly ImagesClient $images;

    public readonly IsosClient $isos;

    public readonly LoadBalancersClient $loadBalancers;

    public readonly LoadBalancerTypesClient $loadBalancerTypes;

    public readonly LocationsClient $locations;

    public readonly NetworksClient $networks;

    public readonly PlacementGroupsClient $placementGroups;

    public readonly PricingClient $pricing;

    public readonly PrimaryIpsClient $primaryIps;

    public readonly ServersClient $servers;

    public readonly ServerTypesClient $serverTypes;

    public readonly SshKeysClient $sshKeys;

    public readonly VolumesClient $volumes;

    public readonly ZonesClient $zones;

    public function __construct(
        string $apiToken,
        ?string $baseUrl = null,
    ) {
        $t = new CurlTransport(
            $apiToken,
            $baseUrl ?? 'https://api.hetzner.cloud/v1',
        );
        $this->actions = new ActionsClient($t);
        $this->certificates = new CertificatesClient($t);
        $this->datacenters = new DatacentersClient($t);
        $this->firewalls = new FirewallsClient($t);
        $this->floatingIps = new FloatingIpsClient($t);
        $this->images = new ImagesClient($t);
        $this->isos = new IsosClient($t);
        $this->loadBalancers = new LoadBalancersClient($t);
        $this->loadBalancerTypes = new LoadBalancerTypesClient($t);
        $this->locations = new LocationsClient($t);
        $this->networks = new NetworksClient($t);
        $this->placementGroups = new PlacementGroupsClient($t);
        $this->pricing = new PricingClient($t);
        $this->primaryIps = new PrimaryIpsClient($t);
        $this->servers = new ServersClient($t);
        $this->serverTypes = new ServerTypesClient($t);
        $this->sshKeys = new SshKeysClient($t);
        $this->volumes = new VolumesClient($t);
        $this->zones = new ZonesClient($t);
    }
}
