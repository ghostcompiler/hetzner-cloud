<?php

declare(strict_types=1);

use Ghostcompiler\Hetzner\ApiException;
use Ghostcompiler\Hetzner\HetznerClient;

header('Content-Type: application/json; charset=utf-8');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'POST only'], JSON_THROW_ON_ERROR);
    exit;
}

$autoload = dirname(__DIR__) . '/vendor/autoload.php';
if (! is_readable($autoload)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Run composer install in project root.'], JSON_THROW_ON_ERROR);
    exit;
}

require_once $autoload;
require_once __DIR__ . '/includes/explorer.php';

$raw = file_get_contents('php://input');
try {
    $body = json_decode($raw ?? '', true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Invalid JSON body'], JSON_THROW_ON_ERROR);
    exit;
}

if (! is_array($body)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Body must be a JSON object'], JSON_THROW_ON_ERROR);
    exit;
}

$token = trim((string) ($body['token'] ?? ''));
$resource = (string) ($body['resource'] ?? '');
$methodName = (string) ($body['method'] ?? '');
$params = $body['params'] ?? [];
if (! is_array($params)) {
    $params = [];
}

if ($token === '' || $resource === '' || $methodName === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'token, resource, and method are required'], JSON_THROW_ON_ERROR);
    exit;
}

$map = hetzner_demo_client_map();
if (! isset($map[$resource])) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Unknown resource'], JSON_THROW_ON_ERROR);
    exit;
}

$ref = new ReflectionClass($map[$resource]);
if (! $ref->hasMethod($methodName)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Unknown method'], JSON_THROW_ON_ERROR);
    exit;
}

$method = $ref->getMethod($methodName);

try {
    $args = hetzner_demo_build_arguments_decoded($method, $params);
} catch (InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => $e->getMessage()], JSON_THROW_ON_ERROR);
    exit;
}

try {
    $hc = new HetznerClient($token);
    $rp = new ReflectionProperty(HetznerClient::class, $resource);
    $sub = $rp->getValue($hc);
    $data = $method->invokeArgs($sub, $args);
    echo json_encode([
        'ok' => true,
        'result' => $data,
    ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
} catch (ApiException $e) {
    http_response_code($e->getHttpStatus() >= 400 && $e->getHttpStatus() < 600 ? $e->getHttpStatus() : 502);
    echo json_encode([
        'ok' => false,
        'apiException' => true,
        'httpStatus' => $e->getHttpStatus(),
        'message' => $e->getMessage(),
        'apiError' => $e->getApiError(),
        'apiErrorCode' => $e->getApiErrorCode(),
    ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'message' => $e->getMessage(),
    ], JSON_THROW_ON_ERROR);
}
