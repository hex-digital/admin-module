<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Filament\Resources\AdminResource\Pages;

use HexDigital\ApiConsoleModule\Filament\Resources\AdminResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;
}
