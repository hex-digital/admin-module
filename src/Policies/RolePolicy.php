<?php

declare(strict_types=1);

namespace HexDigital\AdminModule\Policies;

use HexDigital\AdminModule\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(Admin $admin): bool
    {
        return $admin->can(abilities: 'read:roles');
    }

    public function view(Admin $admin, Role $role): bool
    {
        return $admin->can(abilities: 'read:roles');
    }

    public function create(Admin $admin): bool
    {
        return $admin->can(abilities: 'create:roles');
    }

    public function update(Admin $admin, Role $role): bool
    {
        return $admin->can(abilities: 'update:roles');
    }

    public function delete(Admin $admin, Role $role): bool
    {
        return $admin->can(abilities: 'delete:roles');
    }
}
