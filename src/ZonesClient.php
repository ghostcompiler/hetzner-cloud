<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * DNS zones and RRsets (Hetzner DNS within Cloud API).
 *
 * @see https://docs.hetzner.cloud/reference/cloud#zones
 */
final class ZonesClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listZones(array $query = []): array
    {
        return $this->get('zones', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createZone(array $body): array
    {
        return $this->post('zones', $body);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listZonesActions(array $query = []): array
    {
        return $this->get('zones/actions', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getZonesAction(int|string $id): array
    {
        return $this->get('zones/actions/' . $id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getZone(int|string $idOrName): array
    {
        return $this->get('zones/' . rawurlencode((string) $idOrName));
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateZone(int|string $idOrName, array $body): array
    {
        return $this->put('zones/' . rawurlencode((string) $idOrName), $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deleteZone(int|string $idOrName): array
    {
        return $this->delete('zones/' . rawurlencode((string) $idOrName));
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listZoneActions(int|string $idOrName, array $query = []): array
    {
        $z = rawurlencode((string) $idOrName);

        return $this->get('zones/' . $z . '/actions', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeZonePrimaryNameservers(int|string $idOrName, array $body): array
    {
        $z = rawurlencode((string) $idOrName);

        return $this->post('zones/' . $z . '/actions/change_primary_nameservers', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeZoneProtection(int|string $idOrName, array $body): array
    {
        $z = rawurlencode((string) $idOrName);

        return $this->post('zones/' . $z . '/actions/change_protection', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeZoneTtl(int|string $idOrName, array $body): array
    {
        $z = rawurlencode((string) $idOrName);

        return $this->post('zones/' . $z . '/actions/change_ttl', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function importZoneZonefile(int|string $idOrName, array $body): array
    {
        $z = rawurlencode((string) $idOrName);

        return $this->post('zones/' . $z . '/actions/import_zonefile', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function getZoneAction(int|string $idOrName, int|string $actionId): array
    {
        $z = rawurlencode((string) $idOrName);

        return $this->get('zones/' . $z . '/actions/' . $actionId);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listZoneRrsets(int|string $idOrName, array $query = []): array
    {
        $z = rawurlencode((string) $idOrName);

        return $this->get('zones/' . $z . '/rrsets', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createZoneRrset(int|string $idOrName, array $body): array
    {
        $z = rawurlencode((string) $idOrName);

        return $this->post('zones/' . $z . '/rrsets', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function getZoneRrset(int|string $idOrName, string $rrName, string $rrType): array
    {
        $z = rawurlencode((string) $idOrName);
        $n = self::encodePathSegment($rrName);
        $t = self::encodePathSegment($rrType);

        return $this->get('zones/' . $z . '/rrsets/' . $n . '/' . $t);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateZoneRrset(int|string $idOrName, string $rrName, string $rrType, array $body): array
    {
        $z = rawurlencode((string) $idOrName);
        $n = self::encodePathSegment($rrName);
        $t = self::encodePathSegment($rrType);

        return $this->put('zones/' . $z . '/rrsets/' . $n . '/' . $t, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deleteZoneRrset(int|string $idOrName, string $rrName, string $rrType): array
    {
        $z = rawurlencode((string) $idOrName);
        $n = self::encodePathSegment($rrName);
        $t = self::encodePathSegment($rrType);

        return $this->delete('zones/' . $z . '/rrsets/' . $n . '/' . $t);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function addZoneRrsetRecords(int|string $idOrName, string $rrName, string $rrType, array $body): array
    {
        $path = $this->rrsetActionPath($idOrName, $rrName, $rrType, 'add_records');

        return $this->post($path, $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeZoneRrsetProtection(int|string $idOrName, string $rrName, string $rrType, array $body): array
    {
        $path = $this->rrsetActionPath($idOrName, $rrName, $rrType, 'change_protection');

        return $this->post($path, $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeZoneRrsetTtl(int|string $idOrName, string $rrName, string $rrType, array $body): array
    {
        $path = $this->rrsetActionPath($idOrName, $rrName, $rrType, 'change_ttl');

        return $this->post($path, $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function removeZoneRrsetRecords(int|string $idOrName, string $rrName, string $rrType, array $body): array
    {
        $path = $this->rrsetActionPath($idOrName, $rrName, $rrType, 'remove_records');

        return $this->post($path, $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function setZoneRrsetRecords(int|string $idOrName, string $rrName, string $rrType, array $body): array
    {
        $path = $this->rrsetActionPath($idOrName, $rrName, $rrType, 'set_records');

        return $this->post($path, $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateZoneRrsetRecords(int|string $idOrName, string $rrName, string $rrType, array $body): array
    {
        $path = $this->rrsetActionPath($idOrName, $rrName, $rrType, 'update_records');

        return $this->post($path, $body);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function getZoneZonefile(int|string $idOrName, array $query = []): array
    {
        $z = rawurlencode((string) $idOrName);

        return $this->get('zones/' . $z . '/zonefile', $query);
    }

    private function rrsetActionPath(int|string $idOrName, string $rrName, string $rrType, string $action): string
    {
        $z = rawurlencode((string) $idOrName);
        $n = self::encodePathSegment($rrName);
        $t = self::encodePathSegment($rrType);

        return 'zones/' . $z . '/rrsets/' . $n . '/' . $t . '/actions/' . $action;
    }
}
