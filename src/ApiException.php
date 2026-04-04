<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner;

use Throwable;

/**
 * Thrown when the API returns a non-success HTTP status or JSON cannot be parsed as expected.
 */
final class ApiException extends \RuntimeException
{
    /**
     * @param array<string, mixed>|null $apiError Parsed "error" object from JSON body, if any
     * @param array<string, string> $responseHeaders
     */
    public function __construct(
        string $message,
        private readonly int $httpStatus,
        private readonly ?array $apiError = null,
        private readonly array $responseHeaders = [],
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $httpStatus, $previous);
    }

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getApiError(): ?array
    {
        return $this->apiError;
    }

    public function getApiErrorCode(): ?string
    {
        if ($this->apiError === null || ! isset($this->apiError['code'])) {
            return null;
        }

        return is_string($this->apiError['code']) ? $this->apiError['code'] : null;
    }

    /**
     * @return array<string, string>
     */
    public function getResponseHeaders(): array
    {
        return $this->responseHeaders;
    }
}
