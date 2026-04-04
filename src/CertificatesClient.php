<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

/**
 * @see https://docs.hetzner.cloud/reference/cloud#certificates
 */
final class CertificatesClient extends AbstractResourceClient
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listCertificates(array $query = []): array
    {
        return $this->get('certificates', $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function createCertificate(array $body): array
    {
        return $this->post('certificates', $body);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listCertificatesActions(array $query = []): array
    {
        return $this->get('certificates/actions', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function getCertificatesAction(int|string $id): array
    {
        return $this->get('certificates/actions/' . $id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getCertificate(int|string $id): array
    {
        return $this->get('certificates/' . $id);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function updateCertificate(int|string $id, array $body): array
    {
        return $this->put('certificates/' . $id, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function deleteCertificate(int|string $id): array
    {
        return $this->delete('certificates/' . $id);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listCertificateActions(int|string $id, array $query = []): array
    {
        return $this->get('certificates/' . $id . '/actions', $query);
    }

    /**
     * @return array<string, mixed>
     */
    public function retryCertificate(int|string $id): array
    {
        return $this->post('certificates/' . $id . '/actions/retry', (object) []);
    }

    /**
     * @return array<string, mixed>
     */
    public function getCertificateAction(int|string $id, int|string $actionId): array
    {
        return $this->get('certificates/' . $id . '/actions/' . $actionId);
    }
}
