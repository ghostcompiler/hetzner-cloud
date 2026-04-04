<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#servers
 */
final class ServersClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listServers(array $query = []): array
    {
        return $this->get('servers', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createServer(array $body): array
    {
        return $this->post('servers', $body);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listServersActions(array $query = []): array
    {
        return $this->get('servers/actions', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getServersAction(int|string $id): array
    {
        return $this->get('servers/actions/' . $id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getServer(int|string $id): array
    {
        return $this->get('servers/' . $id);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateServer(int|string $id, array $body): array
    {
        return $this->put('servers/' . $id, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deleteServer(int|string $id): array
    {
        return $this->delete('servers/' . $id);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listServerActions(int|string $id, array $query = []): array
    {
        return $this->get('servers/' . $id . '/actions', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function addServerToPlacementGroup(int|string $id, array $body): array
    {
        return $this->post('servers/' . $id . '/actions/add_to_placement_group', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function attachServerIso(int|string $id, array $body): array
    {
        return $this->post('servers/' . $id . '/actions/attach_iso', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function attachServerToNetwork(int|string $id, array $body): array
    {
        return $this->post('servers/' . $id . '/actions/attach_to_network', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeServerAliasIps(int|string $id, array $body): array
    {
        return $this->post('servers/' . $id . '/actions/change_alias_ips', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeServerDnsPtr(int|string $id, array $body): array
    {
        return $this->post('servers/' . $id . '/actions/change_dns_ptr', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeServerProtection(int|string $id, array $body): array
    {
        return $this->post('servers/' . $id . '/actions/change_protection', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function changeServerType(int|string $id, array $body): array
    {
        return $this->post('servers/' . $id . '/actions/change_type', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createServerImage(int|string $id, array $body): array
    {
        return $this->post('servers/' . $id . '/actions/create_image', $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function detachServerFromNetwork(int|string $id, array $body): array
    {
        return $this->post('servers/' . $id . '/actions/detach_from_network', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function detachServerIso(int|string $id): array
    {
        return $this->post('servers/' . $id . '/actions/detach_iso', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function disableServerBackup(int|string $id): array
    {
        return $this->post('servers/' . $id . '/actions/disable_backup', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function disableServerRescue(int|string $id): array
    {
        return $this->post('servers/' . $id . '/actions/disable_rescue', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function enableServerBackup(int|string $id): array
    {
        return $this->post('servers/' . $id . '/actions/enable_backup', (object) []);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function enableServerRescue(int|string $id, array $body = []): array
    {
        $payload = $body === [] ? (object) [] : $body;

        return $this->post('servers/' . $id . '/actions/enable_rescue', $payload);
    }

    /**
     * @return array<string, mixed>
     */
    public function poweroffServer(int|string $id): array
    {
        return $this->post('servers/' . $id . '/actions/poweroff', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function poweronServer(int|string $id): array
    {
        return $this->post('servers/' . $id . '/actions/poweron', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function rebootServer(int|string $id): array
    {
        return $this->post('servers/' . $id . '/actions/reboot', (object) []);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function rebuildServer(int|string $id, array $body): array
    {
        return $this->post('servers/' . $id . '/actions/rebuild', $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function removeServerFromPlacementGroup(int|string $id): array
    {
        return $this->post('servers/' . $id . '/actions/remove_from_placement_group', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function requestServerConsole(int|string $id): array
    {
        return $this->post('servers/' . $id . '/actions/request_console', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function resetServer(int|string $id): array
    {
        return $this->post('servers/' . $id . '/actions/reset', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function resetServerPassword(int|string $id): array
    {
        return $this->post('servers/' . $id . '/actions/reset_password', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function shutdownServer(int|string $id): array
    {
        return $this->post('servers/' . $id . '/actions/shutdown', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function getServerAction(int|string $id, int|string $actionId): array
    {
        return $this->get('servers/' . $id . '/actions/' . $actionId);
    }

    /**
     * @param array<string, mixed> $query e.g. type, start, end
     * @return array<string, mixed>
     */
    public function getServerMetrics(int|string $id, array $query): array
    {
        return $this->get('servers/' . $id . '/metrics', $query);
    }
}
