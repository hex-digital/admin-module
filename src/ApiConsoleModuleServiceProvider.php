<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule;

use Filament\Facades\Filament;
use Filament\PluginServiceProvider;
use HexDigital\ApiConsoleModule\Commands\MakeUserCommand;
use HexDigital\ApiConsoleModule\Commands\Aliases\MakeUserCommand as MakeUserCommandAlias;
use HexDigital\ApiConsoleModule\Filament\Resources\AdminResource;
use HexDigital\ApiConsoleModule\Models\Admin;
use Spatie\LaravelPackageTools\Package;

final class ApiConsoleModuleServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        AdminResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name(name: 'api-console-module')
            ->hasConfigFile()
            ->hasAssets()
            ->hasMigration(migrationFileName: 'create_admins_table')
            ->hasCommands(commandClassNames: [
                MakeUserCommand::class,
                MakeUserCommandAlias::class,
            ]);
    }

    public function packageRegistered(): void
    {
        parent::packageRegistered();

        config([
            'auth.guards.console' => array_merge([
                'driver' => 'session',
                'provider' => 'admins',
            ], (array) config('auth.guards.console', [])),
            'auth.providers.admins' => array_merge([
                'driver' => 'eloquent',
                'model' => Admin::class,
            ], (array) config('auth.providers.admins', [])),
        ]);
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
