<?php

declare(strict_types=1);

namespace HexDigital\AdminModule\Policies;

use HexDigital\AdminModule\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function viewAny(Admin $admin): bool
    {
        return $admin->can(abilities: 'read:admins');
    }

    public function view(Admin $admin, Admin $model): bool
    {
        return $admin->can(abilities: 'read:admins');
    }

    public function create(Admin $admin): bool
    {
        return false;
    }

    public function update(Admin $admin, Admin $model): bool
    {
        return $admin->can(abilities: 'update:admins') && $admin->isNot(model: $model);
    }

    public function delete(Admin $admin, Admin $model): bool
    {
        return $admin->can(abilities: 'delete:admins') && $admin->isNot(model: $model);
    }

    public function restore(Admin $admin, Admin $model): bool
    {
        return $admin->can(abilities: 'invite:admins');
    }

    public function forceDelete(Admin $admin, Admin $model): bool
    {
        return false;
    }
}
