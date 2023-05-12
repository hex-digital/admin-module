<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Filament\Resources\AdminResource\Pages;

use Filament\Forms\Components\TextInput;
use HexDigital\ApiConsoleModule\Filament\Resources\AdminResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use HexDigital\ApiConsoleModule\Models\Admin;
use HexDigital\ApiConsoleModule\Notifications\InviteAdminNotification;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ListAdmins extends ListRecords
{
    protected static string $resource = AdminResource::class;

    protected function getActions(): array
    {
        /** @var Guard $guard */
        $guard = auth(guard: 'console');

        /** @var Admin $currentAdmin */
        $currentAdmin = $guard->user();

        return [
            Actions\Action::make(name: 'invite_admin')
                ->visible(condition: $currentAdmin->can(abilities: 'invite:admins'))
                ->action(action: function (array $data) use ($currentAdmin): void {
                    // @phpstan-ignore-next-line - call to undefined static method create
                    $admin = Admin::create(attributes: array_merge($data, [
                        'password' => Hash::make(Str::random()),
                    ]));

                    $admin->notify(instance: new InviteAdminNotification(
                        invitedBy: $currentAdmin,
                    ));
                })
                ->modalWidth(width: 'lg')
                ->modalSubheading(subheading: 'This will send an email to the user with a link to set their password.')
                ->form(schema: [
                    TextInput::make('first_name')
                        ->placeholder(placeholder: 'Enter the users first name')
                        ->required()
                        ->string()
                        ->maxValue(value: 255)
                        ->maxWidth(width: 'sm'),

                    TextInput::make('last_name')
                        ->placeholder(placeholder: 'Enter the users last name')
                        ->required()
                        ->string()
                        ->maxValue(value: 255)
                        ->maxWidth(width: 'sm'),

                    TextInput::make('email')
                        ->placeholder(placeholder: 'Enter the users email address')
                        ->required()
                        ->email()
                        ->maxValue(value: 255)
                        ->unique()
                        ->maxWidth(width: 'sm'),
                ]),
        ];
    }
}
