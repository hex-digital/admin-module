<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Policies;

use HexDigital\ApiConsoleModule\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(Admin $admin): bool
    {
        return true;
    }

    public function view(Admin $admin, Role $role): bool
    {
        return true;
    }

    public function create(Admin $admin): bool
    {
        return true;
    }

    public function update(Admin $admin, Role $role): bool
    {
        return true;
    }

    public function delete(Admin $admin, Role $role): bool
    {
        return true;
    }
}
