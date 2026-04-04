<?php

declare(strict_types=1);

use Ghostcompiler\Hetzner\HetznerClient;

/**
 * @return array<string, string> property name => FQCN
 */
function hetzner_demo_client_map(): array
{
    $ref = new ReflectionClass(HetznerClient::class);
    $map = [];
    foreach ($ref->getProperties() as $prop) {
        if (! $prop->isPublic()) {
            continue;
        }
        $type = $prop->getType();
        if (! $type instanceof ReflectionNamedType || $type->isBuiltin()) {
            continue;
        }
        $map[$prop->getName()] = $type->getName();
    }
    ksort($map);

    return $map;
}

/**
 * @return list<ReflectionMethod>
 */
function hetzner_demo_public_methods(string $clientClass): array
{
    $ref = new ReflectionClass($clientClass);
    $methods = [];
    foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC) as $m) {
        if ($m->getDeclaringClass()->getName() !== $clientClass) {
            continue;
        }
        if ($m->isConstructor()) {
            continue;
        }
        $methods[] = $m;
    }
    usort($methods, static fn (ReflectionMethod $a, ReflectionMethod $b) => strcmp($a->getName(), $b->getName()));

    return $methods;
}

function hetzner_demo_type_string(?ReflectionType $t): string
{
    if ($t === null) {
        return 'mixed';
    }
    if ($t instanceof ReflectionNamedType) {
        return ($t->allowsNull() ? '?' : '') . $t->getName();
    }
    if ($t instanceof ReflectionUnionType) {
        $parts = [];
        foreach ($t->getTypes() as $u) {
            $parts[] = $u instanceof ReflectionNamedType ? $u->getName() : 'mixed';
        }

        return implode('|', $parts);
    }

    return 'mixed';
}

function hetzner_demo_param_accepts_array(ReflectionParameter $param): bool
{
    $t = $param->getType();
    if ($t instanceof ReflectionNamedType && $t->getName() === 'array') {
        return true;
    }
    if ($t instanceof ReflectionUnionType) {
        foreach ($t->getTypes() as $sub) {
            if ($sub instanceof ReflectionNamedType && $sub->getName() === 'array') {
                return true;
            }
        }
    }

    return false;
}

/**
 * @param array<string, string> $raw from $_POST['p'] (all string)
 * @return list<mixed> ordered arguments for invokeArgs
 */
function hetzner_demo_build_arguments(ReflectionMethod $method, array $raw): array
{
    $args = [];
    foreach ($method->getParameters() as $param) {
        $name = $param->getName();
        $submitted = array_key_exists($name, $raw) ? $raw[$name] : null;
        $trim = $submitted === null ? '' : trim((string) $submitted);

        if ($trim === '' && $param->isOptional()) {
            $args[] = $param->getDefaultValue();

            continue;
        }

        if (hetzner_demo_param_accepts_array($param)) {
            if ($trim === '') {
                if ($param->isOptional()) {
                    $args[] = $param->getDefaultValue();
                    continue;
                }
                throw new InvalidArgumentException("Parameter \"{$name}\" requires a JSON array.");
            }
            if ($name === 'ids' && ! str_starts_with($trim, '[')) {
                $parts = array_map('trim', explode(',', $trim));
                $parts = array_values(array_filter($parts, static fn (string $x) => $x !== ''));
                $args[] = $parts;
                continue;
            }
            $decoded = json_decode($trim, true);
            if (! is_array($decoded)) {
                throw new InvalidArgumentException("Parameter \"{$name}\" must be valid JSON array (or for \"ids\" use comma-separated numbers).");
            }
            $args[] = $decoded;
            continue;
        }

        if ($trim === '') {
            throw new InvalidArgumentException("Parameter \"{$name}\" is required.");
        }

        $args[] = $trim;
    }

    return $args;
}

/**
 * Build invoke arguments from already-decoded JSON (api.php).
 *
 * @param array<string, mixed> $params keyed by parameter name
 * @return list<mixed>
 */
function hetzner_demo_build_arguments_decoded(ReflectionMethod $method, array $params): array
{
    $args = [];
    foreach ($method->getParameters() as $param) {
        $name = $param->getName();
        if (array_key_exists($name, $params)) {
            $val = $params[$name];
            if (hetzner_demo_param_accepts_array($param)) {
                if (! is_array($val)) {
                    throw new InvalidArgumentException("Parameter \"{$name}\" must be a JSON array/object.");
                }
                $args[] = $val;

                continue;
            }
            if (is_array($val) || is_object($val)) {
                throw new InvalidArgumentException("Parameter \"{$name}\" must be a string or number.");
            }
            $args[] = $val === null || $val === '' ? '' : (string) $val;

            continue;
        }
        if ($param->isOptional()) {
            $args[] = $param->getDefaultValue();

            continue;
        }
        throw new InvalidArgumentException("Missing parameter \"{$name}\".");
    }

    return $args;
}

/**
 * @return array<string, array<string, array{summary: string, detail: string, http: string, path: string}>>
 */
function hetzner_demo_load_summaries(): array
{
    $path = __DIR__ . '/method_summaries.json';
    if (! is_readable($path)) {
        return [];
    }
    try {
        $data = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        return [];
    }

    return is_array($data) ? $data : [];
}

/**
 * Serializable manifest for the single-page demo UI (includes OpenAPI summaries when method_summaries.json is present).
 *
 * @return array<string, list<array<string, mixed>>>
 */
function hetzner_demo_manifest(): array
{
    $map = hetzner_demo_client_map();
    $summaries = hetzner_demo_load_summaries();
    $out = [];
    foreach ($map as $prop => $class) {
        $rows = [];
        foreach (hetzner_demo_public_methods($class) as $m) {
            $plist = [];
            foreach ($m->getParameters() as $p) {
                $def = null;
                if ($p->isOptional() && $p->isDefaultValueAvailable()) {
                    $def = $p->getDefaultValue();
                }
                $plist[] = [
                    'name' => $p->getName(),
                    'type' => hetzner_demo_type_string($p->getType()),
                    'array' => hetzner_demo_param_accepts_array($p),
                    'optional' => $p->isOptional(),
                    'default' => $def,
                ];
            }
            $name = $m->getName();
            $meta = $summaries[$prop][$name] ?? null;
            $rows[] = [
                'name' => $name,
                'params' => $plist,
                'summary' => is_array($meta) ? (string) ($meta['summary'] ?? '') : '',
                'detail' => is_array($meta) ? (string) ($meta['detail'] ?? '') : '',
                'http' => is_array($meta) ? (string) ($meta['http'] ?? '') : '',
                'path' => is_array($meta) ? (string) ($meta['path'] ?? '') : '',
            ];
        }
        $out[$prop] = $rows;
    }

    return $out;
}
