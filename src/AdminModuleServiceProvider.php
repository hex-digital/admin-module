<?php

declare(strict_types=1);

namespace HexDigital\AdminModule;

use Filament\Facades\Filament;
use Filament\PluginServiceProvider;
use HexDigital\AdminModule\Actions\RefactorFileAction;
use HexDigital\AdminModule\Commands\MakeUserCommand;
use HexDigital\AdminModule\Commands\Aliases\MakeUserCommand as FilamentUserCommand;
use HexDigital\AdminModule\Commands\PermissionSyncCommand;
use HexDigital\AdminModule\Commands\PublishCommand;
use HexDigital\AdminModule\Models\Admin;
use HexDigital\AdminModule\Policies\AdminPolicy;
use HexDigital\AdminModule\Policies\RolePolicy;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\Permission\Models\Role;

final class AdminModuleServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name(name: 'admin-module')
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
            'auth.guards.admin' => array_merge([
                'driver' => 'session',
                'provider' => 'admins',
            ], (array) config('auth.guards.admin', [])),
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
                buildDirectory: 'vendor/admin-module',
            );
        });
    }

    protected function getResources(): array
    {
        return (array) config(key: 'admin-module.resources', default: []);
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
                "'guard' => env('FILAMENT_AUTH_GUARD', 'web')" => "'guard' => env('FILAMENT_AUTH_GUARD', 'admin')",
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
            config(key: 'admin-module.admins.model', default: Admin::class) => config(key: 'admin-module.admins.policy', default: AdminPolicy::class),
            config(key: 'permission.models.role', default: Role::class) => config(key: 'admin-module.roles.policy', default: RolePolicy::class),
        ];
    }
}
