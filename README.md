# Admin Module

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hex-digital/admin-module.svg?style=flat-square)](https://packagist.org/packages/hex-digital/admin-module)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/hex-digital/admin-module/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/hex-digital/admin-module/actions/workflows/tests.yaml)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/hex-digital/admin-module/coding-standards.yml?label=code%20style&style=flat-square)](https://github.com/hex-digital/admin-module/actions/workflows/coding-standards.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/hex-digital/admin-module.svg?style=flat-square)](https://packagist.org/packages/hex-digital/admin-module)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require hex-digital/admin-module
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="admin-module-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="admin-module-config"
```

## Usage

```php
$variable = new HexDigital\ApiConsoleModule();
echo $variable->echoPhrase('Hello, Hex Digital!');
```

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
