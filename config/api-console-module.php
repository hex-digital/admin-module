<?php

declare(strict_types=1);

use HexDigital\ApiConsoleModule\Filament\Resources\AdminResource;
use HexDigital\ApiConsoleModule\Filament\Resources\RoleResource;
use HexDigital\ApiConsoleModule\Models\Admin;
use HexDigital\ApiConsoleModule\Policies\AdminPolicy;
use HexDigital\ApiConsoleModule\Policies\RolePolicy;

return [

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | These are the resources that will be registered with Filament in
    | addition to any custom Filament resources that created at a
    | project level.
    |
    */

    'resources' => [
        AdminResource::class,
        RoleResource::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admins
    |--------------------------------------------------------------------------
    |
    | Configure the Admin model and Filament resource.
    |
    */

    'admins' => [
        'model' => Admin::class,

        'policy' => AdminPolicy::class,

        'navigation_group' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admins
    |--------------------------------------------------------------------------
    |
    | Configure the Filament resource for the Role model.
    |
    */

    'roles' => [
        'policy' => RolePolicy::class,

        'navigation_group' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    |
    | These permissions will be created when running the permission:sync
    | command. Permissions can be assigned to roles via the Role
    | resource in Filament.
    |
    */

    'permissions' => [
        'read:admins' => 'View Admins',
        'invite:admins' => 'Invite Admins',
        'update:admins' => 'Update Admins',
        'delete:admins' => 'Delete Admins',
        'read:roles' => 'View Roles',
        'create:roles' => 'Create Roles',
        'update:roles' => 'Update Roles',
        'delete:roles' => 'Delete Roles',
    ],

];
