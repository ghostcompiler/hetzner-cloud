<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner\Tests\Unit;

use Ghostcompiler\Hetzner\HetznerClient;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class HetznerClientStructureTest extends TestCase
{
    public function testExposesAllResourceClients(): void
    {
        $expected = [
            'actions',
            'certificates',
            'datacenters',
            'firewalls',
            'floatingIps',
            'images',
            'isos',
            'loadBalancers',
            'loadBalancerTypes',
            'locations',
            'networks',
            'placementGroups',
            'pricing',
            'primaryIps',
            'servers',
            'serverTypes',
            'sshKeys',
            'volumes',
            'zones',
        ];

        $ref = new ReflectionClass(HetznerClient::class);
        $names = [];
        foreach ($ref->getProperties() as $prop) {
            if ($prop->isPublic()) {
                $names[] = $prop->getName();
            }
        }

        sort($names);
        sort($expected);
        self::assertSame($expected, $names);
    }

    public function testServersClientHasManyPublicMethods(): void
    {
        $ref = new ReflectionClass(\Ghostcompiler\Hetzner\ServersClient::class);
        $public = array_filter(
            $ref->getMethods(\ReflectionMethod::IS_PUBLIC),
            static fn (\ReflectionMethod $m) => $m->getDeclaringClass()->getName() === $ref->getName(),
        );
        self::assertGreaterThan(25, count($public), 'servers API surface should include many action methods');
    }
}
