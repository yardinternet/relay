# Relay

> A bridge between your WordPress site’s internals and your monitoring tools.

## About

Yard's fork of [Relay by Verdant Studio](https://www.verdant.studio/), published as `yard/relay` and served by satis. It builds on upstream and expands upon the capabilities.

## What this fork adds

- `includes/relay-extra.php`, which lets deploy tooling attach values to a payload without touching code: `wp option update relay_extra_data '{"branch":"main"}' --format=json`, or the `relay_extra_data` filter. The sites monitor reads `branch`, `stage` and `server` from it.
- A per-subsite `health_rating` in the core endpoint, so a network's subsites report their own site health instead of inheriting the main site's.

## Endpoints

Registered under `relay/v1`, both requiring the `X-Relay-API-Key` header:

| Endpoint | Returns |
| --- | --- |
| `/wp-json/relay/v1/core` | WordPress version, site health rating, plugin updates available, directory sizes, and for a multisite its subsites with each one's health rating |
| `/wp-json/relay/v1/plugins` | Every installed plugin with its slug, version, active and network-active state, and whether an update is waiting |

## Requirements

- WordPress 5.2 or newer
- PHP 7.4 or newer
- Composer

## Development

```sh
# install composer deps
composer i
```

## Versioning

This fork restarted at 1.0.0. Files inherited from upstream keep upstream's `@since` numbers and say so in their header; `relay-extra.php` is Yard's and uses this plugin's own numbering.

## Documentation

Upstream's [documentation](https://docs.verdant.studio/relay/) covers the shared behaviour.
