<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule;

use Filament\Facades\Filament;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class ApiConsoleModuleServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name(name: 'api-console-module')
            ->hasConfigFile()
            ->hasAssets();
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        Filament::serving(callback: function (): void {
            Filament::registerViteTheme(
                theme: 'resources/css/filament.css',
                buildDirectory: 'vendor/api-console-module',
            );
        });
    }
}
