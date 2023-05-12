<?php

declare(strict_types=1);

namespace HexDigital\AdminModule\Filament\Resources\AdminResource\Pages;

use HexDigital\AdminModule\Filament\Resources\AdminResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;
}
