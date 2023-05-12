<?php

declare(strict_types=1);

namespace HexDigital\AdminModule\Filament\Resources\RoleResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use HexDigital\AdminModule\Filament\Resources\RoleResource;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;
}
