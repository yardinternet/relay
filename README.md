# Relay

> A secure bridge between your WordPress site's internals and your monitoring tools.

## About

The plugin is designed to be used with [Hub](https://github.com/verdant-studio/hub) or any other monitoring tool that can consume the data exposed by the plugin.

## Requirements

- PHP >7.4
- Composer

## Development

```sh
# install composer deps
composer i
```

## Deployment

1. Update the changelog inside the `readme.txt`.
2. Update the version inside `relay.php` (x2) and `readme.txt`
3. Update the translations `wp i18n make-pot . languages/relay.pot --include="includes"`
4. Commit, tag and push the release:

```sh
git add .
git commit -m "(release): v1.0.0"
git tag v1.0.0
git push origin main
git push --tags origin
```

The new version is automatically deployed to the WordPress.org subversion repository.

## Documentation

View the [documentation](https://docs.verdant.studio/relay/) for more information.
