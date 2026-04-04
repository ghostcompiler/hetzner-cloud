<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#actions
 *
 * Note: GET /actions requires one or more `id` query parameters; listing all actions was removed.
 */
final class ActionsClient extends AbstractResourceClient
{
    /**
     * @param list<int|string> $ids Action IDs (sent as repeated `id` query params)
     * @param array<string, mixed> $extra e.g. sort, page, per_page
     * @return array<string, mixed>
     */
    public function getActions(array $ids, array $extra = []): array
    {
        $query = array_merge(['id' => array_map(static fn (int|string $x): string => (string) $x, $ids)], $extra);

        return $this->get('actions', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getAction(int|string $id): array
    {
        return $this->get('actions/' . $id);
    }
}
