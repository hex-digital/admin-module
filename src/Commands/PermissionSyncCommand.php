<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'permission:sync')]
final class PermissionSyncCommand extends Command
{
    protected $signature = 'permission:sync';

    protected $description = 'Sync the available permissions with the database.';

    public function handle(): void
    {
        $permissions = (array) config(key: 'api-console-module.permissions', default: []);

        foreach ($permissions as $name => $displayName) {
            // @phpstan-ignore-next-line - Call to undefined static method updateOrCreate
            Permission::updateOrCreate(
                attributes: [
                    'name' => $name,
                    'guard_name' => 'console',
                ],
                values: [
                    'display_name' => $displayName,
                ],
            );
        }

        Permission::query()
            ->whereNotIn(column: 'name', values: array_keys(array: $permissions))
            ->where(column: 'guard_name', operator: 'console')
            ->delete();

        $this->info(string: 'Permissions successfully synced.');
    }
}
