<?php

declare(strict_types=1);

namespace HexDigital\AdminModule\Filament\Resources\AdminResource\Pages;

use HexDigital\AdminModule\Filament\Resources\AdminResource;
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
