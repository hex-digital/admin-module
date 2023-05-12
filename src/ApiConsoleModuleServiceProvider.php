<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule;

use Filament\Facades\Filament;
use Filament\PluginServiceProvider;
use HexDigital\ApiConsoleModule\Actions\RefactorFileAction;
use HexDigital\ApiConsoleModule\Commands\MakeUserCommand;
use HexDigital\ApiConsoleModule\Commands\Aliases\MakeUserCommand as FilamentUserCommand;
use HexDigital\ApiConsoleModule\Commands\PublishCommand;
use HexDigital\ApiConsoleModule\Models\Admin;
use HexDigital\ApiConsoleModule\Policies\AdminPolicy;
use HexDigital\ApiConsoleModule\Policies\RolePolicy;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\Permission\Models\Role;

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
            ->hasMigrations(migrationFileNames: [
                'create_admins_table',
                'add_display_name_to_permissions_table',
            ])
            ->hasCommands(commandClassNames: [
                FilamentUserCommand::class,
                MakeUserCommand::class,
                PermissionSyncCommand::class,
                PublishCommand::class,
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

        $this->booting(function (): void {
            foreach ($this->policies() as $model => $policy) {
                Gate::policy(class: $model, policy: $policy);
            }
        });
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        Gate::after(fn (Authorizable $authorizable) => $authorizable instanceof Admin && $authorizable->can(abilities: 'super'));

        Filament::serving(callback: function (): void {
            Filament::registerViteTheme(
                theme: 'resources/css/filament.css',
                buildDirectory: 'vendor/api-console-module',
            );
        });
    }

    protected function getResources(): array
    {
        return (array) config(key: 'api-console-module.resources', default: []);
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

        $command->comment(string: 'Publishing filament breezy config file...');
        $command->callSilently(
            command: 'vendor:publish',
            arguments: [
                '--tag' => 'filament-breezy-config',
            ],
        );
    }

    protected function setFilamentDefaults(InstallCommand $command): void
    {
        /** @var RefactorFileAction $refactorFileAction */
        $refactorFileAction = $this->app->make(abstract: RefactorFileAction::class);

        $command->comment(string: 'Updating filament config...');

        $refactorFileAction->execute(
            path: config_path('filament.php'),
            refactors: [
                "'path' => env('FILAMENT_PATH', 'admin')" => "'path' => env('FILAMENT_PATH', 'console')",
                "'home_url' => '/'" => "'home_url' => '/' . env('FILAMENT_PATH', 'console')",
                "'guard' => env('FILAMENT_AUTH_GUARD', 'web')" => "'guard' => env('FILAMENT_AUTH_GUARD', 'console')",
                "'login' => \Filament\Http\Livewire\Auth\Login::class" => "'login' => \JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Login::class",
                "'should_show_logo' => true" => "'should_show_logo' => false",
                "'width' => null" => "'width' => '18rem'",
            ],
        );

        $command->comment(string: 'Updating filament breezy config...');

        $refactorFileAction->execute(
            path: config_path('filament-breezy.php'),
            refactors: [
                '"enable_registration" => true' => '"enable_registration" => false',
            ],
        );
    }

    protected function policies(): array
    {
        return [
            config(key: 'api-console-module.admins.model', default: Admin::class) => config(key: 'api-console-module.admins.policy', default: AdminPolicy::class),
            config(key: 'permission.models.role', default: Role::class) => config(key: 'api-console-module.roles.policy', default: RolePolicy::class),
        ];
    }
}
