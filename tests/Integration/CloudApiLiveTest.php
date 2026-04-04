<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner\Tests\Integration;

use Ghostcompiler\Hetzner\HetznerClient;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('integration')]
final class CloudApiLiveTest extends TestCase
{
    public function testListLocations(): void
    {
        $token = getenv('HETZNER_TOKEN');
        if ($token === false || $token === '') {
            self::markTestSkipped('Set HETZNER_TOKEN to run live API tests.');
        }

        $client = new HetznerClient($token);
        $data = $client->locations->listLocations();

        self::assertArrayHasKey('locations', $data);
        self::assertIsArray($data['locations']);
    }
}
