<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Filament\Resources\AdminResource\Pages;

use HexDigital\ApiConsoleModule\Filament\Resources\AdminResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
