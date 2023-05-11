<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Filament\Resources;

use HexDigital\ApiConsoleModule\Filament\Resources\AdminResource\Pages;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use HexDigital\ApiConsoleModule\Filament\Resources\AdminResource\RelationManagers\RolesRelationManager;
use HexDigital\ApiConsoleModule\Models\Admin;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-add';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make(schema: [
                    Forms\Components\Grid::make()
                        ->schema(components: [
                            Forms\Components\TextInput::make(name: 'first_name')
                                ->required()
                                ->string()
                                ->maxValue(value: 255),

                            Forms\Components\TextInput::make(name: 'last_name')
                                ->required()
                                ->string()
                                ->maxValue(value: 255),

                            Forms\Components\TextInput::make(name: 'email')
                                ->required()
                                ->email()
                                ->unique(ignoreRecord: true)
                                ->maxValue(value: 255),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'first_name'),
                Tables\Columns\TextColumn::make(name: 'last_name'),
                Tables\Columns\TextColumn::make(name: 'email'),
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RolesRelationManager::class,
        ];
    }
}
