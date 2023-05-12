# Admin Module

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hex-digital/admin-module.svg?style=flat-square)](https://packagist.org/packages/hex-digital/admin-module)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/hex-digital/admin-module/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/hex-digital/admin-module/actions/workflows/tests.yaml)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/hex-digital/admin-module/coding-standards.yml?label=code%20style&style=flat-square)](https://github.com/hex-digital/admin-module/actions/workflows/coding-standards.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/hex-digital/admin-module.svg?style=flat-square)](https://packagist.org/packages/hex-digital/admin-module)

This module provides the core admin functionality for our Laravel projects. This module automatically takes care of
installing and configuring [Filament](https://filamentphp.com), managing admins and managing admin roles and
permissions.

## Installation

To get started with the admin module, you can install the pacakge via composer:

```bash
composer require hex-digital/admin-module
```

Next, you'll need to publish the config file, migrations and assets for the module and module dependencies. To simplfy
this, the module comes with an install command:

```bash
php artisan admin-module:install
```

Every time you upgrade the module or Filament, you need to run the `admim:module` and `filament:upgrade` commands. We
recommend adding this to your composer.json's post-update-cmd:

```json
"post-update-cmd": [
    // ...
    "@php artisan filament:upgrade",
    "@php artisan admin-module:publish",
],
```

You should now run your migrations and sync the permissions:

```bash
php artisan migrate
php artisan permission:sync
```

Lastly, you can create a new admin account using:

```bash
php artisan make:filament-user
```

Visit your admin panel at `/admin` to sign in, and you're ready to start building.

## Usage

### Models & Resources

The admin module ships with an `Admin` which is used for authentication. You can override this model by setting the
`admin-module.admins.model` config.

Under the hood, we use the Spatie Roles and Permissions package for authorization of admins. The admin module exposes
a resource for managing both admins and roles.

You can customise these models / resources by editing the config.

### Permissions

The admin module exposes a `permission:sync` commandwhich allows you to sync permissions which can then be assigned to
roles. By default, the module provides permissions for managing admins and roles. However, you can add your own
permissions to the `admin-module.permissions` config.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover a security vulnerability, please send an e-mail to dev@hexdigital.com. All security vulnerabilities
will be promptly addressed.

## Credits

- [Ben Sherred](https://github.com/bensherred)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
