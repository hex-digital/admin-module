<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Filament\Resources\AdminResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Columns\TextColumn;
use HexDigital\ApiConsoleModule\Models\Admin;
use Illuminate\Contracts\Auth\Guard;
use Spatie\Permission\Models\Role;

final class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(name: 'name')
                    ->searchable()
                    ->sortable(),
            ])
            ->headerActions(actions: [
                Action::make(name: 'attach_role')
                    ->action(action: function (array $data): void {
                        /** @var Guard $guard */
                        $guard = auth(guard: 'console');

                        /** @var Admin $admin */
                        $admin = $guard->user();

                        $role = Role::findById((int) $data['roleId']);

                        $admin->assignRole($role);
                    })
                    ->label(label: 'Attach')
                    ->modalHeading(heading: 'Attach role')
                    ->button()
                    ->color(color: 'secondary')
                    ->form(schema: [
                        Select::make(name: 'roleId')
                            ->disableLabel()
                            ->options(options: fn () => Role::query()->pluck(column: 'name', key: 'id'))
                            ->maxWidth(width: 'sm')
                            ->searchable()
                            ->required(),
                    ])
                    ->modalWidth(width: 'lg'),
            ])
            ->actions(actions: [
                DetachAction::make(),
            ])
            ->bulkActions(actions: [
                DetachBulkAction::make(),
            ]);
    }
}
