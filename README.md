# Hetzner Cloud API — PHP client (cURL)

[![PHP >=8.1](https://img.shields.io/badge/php-%3E%3D8.1-777bb4)](https://www.php.net/)
![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)

PHP library for the [Hetzner Cloud API](https://docs.hetzner.cloud/reference/cloud). HTTP is done with **PHP’s `curl` extension only** (no PECL `http`, no Guzzle, no stream wrappers), so you avoid common extension clashes across PHP installs.

Official OpenAPI description: [cloud.spec.json](https://docs.hetzner.cloud/cloud.spec.json).

## Architecture diagram

![Request flow from your app through HetznerClient to the API](docs/architecture.svg)

## Requirements

- PHP **8.1+**
- Extensions: **`curl`**, **`json`**

## Installation

```bash
composer require ghostcompiler/hetzner
```

Or add the path repository if you develop locally:

```json
{
  "repositories": [{ "type": "path", "url": "../hetzner" }],
  "require": { "ghostcompiler/hetzner": "*" }
}
```

## Quick start

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Ghostcompiler\Hetzner\HetznerClient;
use Ghostcompiler\Hetzner\ApiException;

$token = getenv('HETZNER_TOKEN') ?: '';
$hc = new HetznerClient($token);

try {
    $data = $hc->locations->listLocations();
    // $data is the decoded JSON root, e.g. [ 'locations' => [...], 'meta' => [...] ]
} catch (ApiException $e) {
    echo $e->getMessage(), ' (HTTP ', $e->getHttpStatus(), ")\n";
    if ($e->getApiErrorCode()) {
        echo 'API code: ', $e->getApiErrorCode(), "\n";
    }
}
```

### Optional base URL

For testing or proxies, pass a second argument:

```php
$hc = new HetznerClient($token, 'https://api.hetzner.cloud/v1');
```

## Testing (PHPUnit)

Install dev dependencies, then run the default suite (no real API calls):

```bash
composer install
composer test
# same as: ./vendor/bin/phpunit
```

By default, **integration** tests that call Hetzner are **excluded**. To run them, set a project API token and enable the group:

```bash
export HETZNER_TOKEN='your-token-here'
./vendor/bin/phpunit --group integration
```

## Interactive demo (browser)

The [`demo/`](demo/) folder is a **single-page explorer** (uses a little JavaScript for `fetch` + copy):

1. Enter your **API token** once at the top (optional **Save in browser** → `localStorage`).
2. Expand any **resource client** — every **public method** is listed with an **official summary**, **HTTP verb**, **path**, and a **short description** (from Hetzner’s OpenAPI spec), plus usage hints.
3. Adjust parameters (JSON in textareas for `query` / `body` / `ids`, etc.), click **Run** for a **live** call via [`demo/api.php`](demo/api.php).
4. **Copy response** copies the full JSON (success or error) to the clipboard.

Use the **search box** to filter clients/methods by name.

**Security:** local use only; do not expose `demo/` on a public server.

From the **repository root**:

```bash
composer install
php -S 127.0.0.1:8080 -t demo
```

Open [http://127.0.0.1:8080](http://127.0.0.1:8080) in your browser.

## Method reference (every command, with descriptions)

The file **[docs/METHOD_REFERENCE.md](docs/METHOD_REFERENCE.md)** lists **all** public SDK methods in English: for each one you get the **official summary**, **HTTP method**, **API path**, and a **short description** (derived from the [Hetzner Cloud OpenAPI spec](https://docs.hetzner.cloud/cloud.spec.json)).

To refresh summaries after an API change, run:

```bash
python3 scripts/build_method_summaries.py
```

If `demo/includes/cloud.spec.cache.json` is missing, the script **downloads** the spec from Hetzner automatically. You can also fetch it yourself:

```bash
curl -sL "https://docs.hetzner.cloud/cloud.spec.json" -o demo/includes/cloud.spec.cache.json
python3 scripts/build_method_summaries.py
```

That updates [`demo/includes/method_summaries.json`](demo/includes/method_summaries.json) (used by the demo UI) and [`docs/METHOD_REFERENCE.md`](docs/METHOD_REFERENCE.md).

## How requests are built

```mermaid
flowchart LR
  app[Your_code]
  facade[HetznerClient]
  sub[Resource_clients]
  curl[CurlTransport]
  api[api.hetzner.cloud]
  app --> facade
  facade --> sub
  sub --> curl
  curl --> api
```

1. You call a method on a resource client (for example `$hc->servers->listServers()`).
2. The client builds a path and query/body and delegates to `CurlTransport`.
3. cURL sends HTTPS with `Authorization: Bearer <token>` and `Accept: application/json`.
4. On **HTTP 2xx**, the JSON body is decoded to a PHP `array` and returned.
5. On **HTTP 4xx/5xx** or cURL failure, an `ApiException` is thrown.

## Authentication

Create a token in the [Hetzner Cloud Console](https://console.hetzner.cloud/) under your project: **Security → API Tokens**. Pass it as the first constructor argument. Tokens are scoped to one project.

## Pagination, sorting, filters

List endpoints accept an optional `$query` array. Keys are sent as query parameters. **Array values** become repeated keys (for example multiple `sort` or `id` values):

```php
$hc->servers->listServers([
    'page' => 1,
    'per_page' => 50,
    'label_selector' => 'env=production',
    'sort' => ['name:asc', 'id:desc'],
]);
```

See the official docs for each resource’s supported query parameters.

## Rate limiting

Successful responses include headers such as `RateLimit-Limit`, `RateLimit-Remaining`, and `RateLimit-Reset`. This library throws on error status codes before you would read those headers on success responses. For advanced use, you could extend `CurlTransport` to expose full responses; by default resource methods return **only the decoded JSON body** as an array.

## Errors

Failures throw `Ghostcompiler\Hetzner\ApiException`:

| Method | Meaning |
|--------|---------|
| `getMessage()` | Human-readable message (from API when available) |
| `getHttpStatus()` | HTTP status code |
| `getApiError()` | Full `error` object from JSON, if present |
| `getApiErrorCode()` | Short machine code, e.g. `invalid_input` |
| `getResponseHeaders()` | Parsed response headers (lowercase names) |

Error format reference: [Hetzner API — Errors](https://docs.hetzner.cloud/reference/cloud#error-codes).

## Important: global Actions list

`GET /actions` **no longer lists all actions**. You must pass one or more action IDs as repeated `id` query parameters. Use `ActionsClient::getActions()`:

```php
$hc->actions->getActions([1001, 1002], ['per_page' => 25]);
```

## Resource clients and methods

Each method maps to one HTTP call. Bodies are PHP `array` values shaped like the JSON in the [official API docs](https://docs.hetzner.cloud/reference/cloud). Many POST actions send an empty JSON object `{}` internally when no fields are required.

**Full catalog:** every method name with **what it does** (summary + description) is in **[docs/METHOD_REFERENCE.md](docs/METHOD_REFERENCE.md)**. The same text appears in the [interactive demo](demo/) next to each method.

### What each `HetznerClient` property is for

| Property | PHP class | Purpose |
| --- | --- | --- |
| `actions` | `ActionsClient` | Fetch asynchronous **Action** objects (tasks) by id; global listing was removed by Hetzner—see note above. |
| `certificates` | `CertificatesClient` | TLS certificates (**uploaded** PEM or **managed** Let's Encrypt via Hetzner DNS). |
| `datacenters` | `DatacentersClient` | List **datacenters** (where servers can run). |
| `firewalls` | `FirewallsClient` | **Firewalls**: rules, attach/detach to servers, etc. |
| `floatingIps` | `FloatingIpsClient` | **Floating IPv4/IPv6** addresses and assign/unassign to servers. |
| `images` | `ImagesClient` | **Images** (OS, snapshots, backups): list, update labels, delete, protection. |
| `isos` | `IsosClient` | **ISO** images for manual OS installs. |
| `loadBalancers` | `LoadBalancersClient` | **Load balancers**, targets, services, networks, metrics. |
| `loadBalancerTypes` | `LoadBalancerTypesClient` | Available **load balancer product types** and pricing hints. |
| `locations` | `LocationsClient` | **Locations** (cities/regions) and metadata. |
| `networks` | `NetworksClient` | **Private networks**, subnets, routes, vswitch coupling. |
| `placementGroups` | `PlacementGroupsClient` | **Placement groups** (e.g. spread VMs across hardware). |
| `pricing` | `PricingClient` | **List prices** for resource types in the project currency. |
| `primaryIps` | `PrimaryIpsClient` | **Primary IPs** bound to a location; assign to servers. |
| `servers` | `ServersClient` | **Servers** (VMs): CRUD, power, rescue, backups, networks, metrics, etc. |
| `serverTypes` | `ServerTypesClient` | **Server plans** (`cx22`, …) and pricing hints. |
| `sshKeys` | `SshKeysClient` | **SSH public keys** injected at server create. |
| `volumes` | `VolumesClient` | **Volumes** (block storage): attach, detach, resize. |
| `zones` | `ZonesClient` | **DNS zones** and **RRsets** (records) on Hetzner nameservers. |

### Code examples

Create a server, manage DNS, TLS, and load balancer (field names must match the official API):

```php
$hc->servers->createServer([
    'name' => 'app-1',
    'server_type' => 'cx22',
    'image' => 'ubuntu-22.04',
    'location' => 'nbg1',
    'ssh_keys' => [123456],
]);
$hc->servers->poweronServer(42);

$hc->certificates->createCertificate([
    'name' => 'api-cert',
    'type' => 'managed',
    'domain_names' => ['api.example.com'],
]);

$hc->loadBalancers->createLoadBalancer([
    'name' => 'lb1',
    'load_balancer_type' => 'lb11',
    'location' => 'nbg1',
    'network' => 12345,
    'services' => [],
    'targets' => [],
]);

$hc->zones->listZones();
$hc->zones->getZoneRrset('example.com', '@', 'A');
$hc->zones->setZoneRrsetRecords('example.com', 'www', 'A', [
    'records' => [['value' => '1.2.3.4']],
]);
```

## License

SPDX: `MIT` (see [composer.json](composer.json)).
