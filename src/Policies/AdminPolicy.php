<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Policies;

use HexDigital\ApiConsoleModule\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function viewAny(Admin $admin): bool
    {
        return true;
    }

    public function view(Admin $admin, Admin $model): bool
    {
        return true;
    }

    public function create(Admin $admin): bool
    {
        return true;
    }

    public function update(Admin $admin, Admin $model): bool
    {
        return $admin->isNot(model: $model);
    }

    public function delete(Admin $admin, Admin $model): bool
    {
        return $admin->isNot(model: $model);
    }

    public function restore(Admin $admin, Admin $model): bool
    {
        return true;
    }

    public function forceDelete(Admin $admin, Admin $model): bool
    {
        return false;
    }
}
