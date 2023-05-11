<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule;

use Filament\Facades\Filament;
use Filament\PluginServiceProvider;
use HexDigital\ApiConsoleModule\Actions\RefactorFileAction;
use HexDigital\ApiConsoleModule\Commands\MakeUserCommand;
use HexDigital\ApiConsoleModule\Commands\Aliases\MakeUserCommand as MakeUserCommandAlias;
use HexDigital\ApiConsoleModule\Filament\Resources\AdminResource;
use HexDigital\ApiConsoleModule\Filament\Resources\RoleResource;
use HexDigital\ApiConsoleModule\Models\Admin;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;

final class ApiConsoleModuleServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name(name: 'api-console-module')
            ->hasConfigFile()
            ->hasInstallCommand(callable: function (InstallCommand $command): void {
                $command
                    ->startWith(callable: function (InstallCommand $command): void {
                        $this->publishDependencies($command);
                        $this->setFilamentDefaults($command);
                    })
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publishMigrations()
                    ->askToRunMigrations();
            })
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

    protected function getResources(): array
    {
        return [
            AdminResource::class,
            RoleResource::class,
        ];
    }

    protected function publishDependencies(InstallCommand $command): void
    {
        $command->comment(string: 'Publishing filament config file...');
        $command->callSilently(
            command: 'vendor:publish',
            arguments: [
                '--tag' => 'filament-config',
            ],
        );

        $command->comment(string: 'Publishing laravel permission config file...');
        $command->callSilently(
            command: 'vendor:publish',
            arguments: [
                '--tag' => 'permission-config',
            ],
        );

        $command->comment(string: 'Publishing laravel permission migrations file...');
        $command->callSilently(
            command: 'vendor:publish',
            arguments: [
                '--tag' => 'permission-migrations',
            ],
        );
    }

    protected function setFilamentDefaults(InstallCommand $command): void
    {
        $command->comment(string: 'Updating default filament config...');

        /** @var RefactorFileAction $refactorFileAction */
        $refactorFileAction = $this->app->make(abstract: RefactorFileAction::class);

        $refactorFileAction->execute(
            path: config_path('filament.php'),
            refactors: [
                "'path' => env('FILAMENT_PATH', 'admin')" => "'path' => env('FILAMENT_PATH', 'console')",
                "'home_url' => '/'" => "'home_url' => '/' . env('FILAMENT_PATH', 'console')",
                "'guard' => env('FILAMENT_AUTH_GUARD', 'web')" => "'guard' => env('FILAMENT_AUTH_GUARD', 'console')",
                "'width' => null" => "'width' => '18rem'",
            ],
        );
    }
}
