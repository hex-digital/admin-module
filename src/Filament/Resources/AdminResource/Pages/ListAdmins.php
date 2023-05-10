<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Filament\Resources\AdminResource\Pages;

use HexDigital\ApiConsoleModule\Filament\Resources\AdminResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdmins extends ListRecords
{
    protected static string $resource = AdminResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
