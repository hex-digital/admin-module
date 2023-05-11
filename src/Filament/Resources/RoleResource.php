<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Filament\Resources;

use HexDigital\ApiConsoleModule\Filament\Resources\RoleResource\Pages;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getModel(): string
    {
        /** @var string $model */
        $model = config(key: 'permission.models.role', default: Role::class);

        return $model;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make(schema: [
                    Forms\Components\Grid::make()
                        ->schema(components: [
                            Forms\Components\TextInput::make(name: 'name')
                                ->required()
                                ->string()
                                ->maxValue(value: 255),

                            Forms\Components\Select::make(name: 'permissions')
                                ->multiple()
                                ->relationship(relationshipName: 'permissions', titleColumnName: 'name'),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'name')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('permissions')
                    ->getStateUsing(function ($record) {
                        $permissionCount = $record->permissions()->count();
                        $label = Str::plural(value: 'permission', count: $permissionCount);

                        return "{$permissionCount} {$label}";
                    })
                    ->color(color: 'success'),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
