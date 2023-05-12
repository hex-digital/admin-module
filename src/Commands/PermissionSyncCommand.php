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

        $this->upsertPermission(name: 'super', displayName: 'Super Admin');

        /**
         * @var string $name
         * @var string $displayName
         */
        foreach ($permissions as $name => $displayName) {
            $this->upsertPermission(name: $name, displayName: $displayName);
        }

        Permission::query()
            ->where(column: 'name', operator: '=', value: 'super')
            ->whereNotIn(column: 'name', values: array_keys(array: $permissions))
            ->where(column: 'guard_name', operator: '=', value: 'console')
            ->delete();

        $this->callSilently(command: 'permission:cache-reset');

        $this->info(string: 'Permissions successfully synced.');
    }

    protected function upsertPermission(string $name, string $displayName): Permission
    {
        // @phpstan-ignore-next-line - Call to undefined static method updateOrCreate
        return Permission::updateOrCreate(
            attributes: [
                'name' => $name,
                'guard_name' => 'console',
            ],
            values: [
                'display_name' => $displayName,
            ],
        );
    }
}
