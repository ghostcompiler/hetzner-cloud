<?php

declare(strict_types=1);

namespace Ghostcompiler\Hetzner\Tests\Unit;

use Ghostcompiler\Hetzner\ApiException;
use PHPUnit\Framework\TestCase;

final class ApiExceptionTest extends TestCase
{
    public function testGetters(): void
    {
        $err = ['code' => 'invalid_input', 'message' => 'bad'];
        $e = new ApiException('bad', 422, $err, ['x-foo' => 'bar']);

        self::assertSame('bad', $e->getMessage());
        self::assertSame(422, $e->getHttpStatus());
        self::assertSame($err, $e->getApiError());
        self::assertSame('invalid_input', $e->getApiErrorCode());
        self::assertSame(['x-foo' => 'bar'], $e->getResponseHeaders());
    }

    public function testApiErrorCodeMissing(): void
    {
        $e = new ApiException('x', 500, ['message' => 'm']);
        self::assertNull($e->getApiErrorCode());
    }
}
