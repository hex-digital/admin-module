<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class ApiConsoleModuleServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name(name: 'api-console-module')
            ->hasConfigFile();
    }
}
