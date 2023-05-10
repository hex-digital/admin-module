<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Commands;

use Filament\Commands\MakeUserCommand as FilamentMakeUserCommand;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:filament-user')]
class MakeUserCommand extends FilamentMakeUserCommand
{
    protected $description = 'Creates a Filament user.';

    protected $signature = 'make:filament-user
                            {--firstname= : The first name of the user}
                            {--lastname= : The last name of the user}
                            {--email= : A valid and unique email address}
                            {--password= : The password for the user (min. 8 characters)}';

    protected function getUserData(): array
    {
        return [
            'first_name' => $this->validateInput(fn () => $this->options['firstname'] ?? $this->ask('First name'), 'firstname', ['required'], fn () => $this->options['firstname'] = null),
            'last_name' => $this->validateInput(fn () => $this->options['lastname'] ?? $this->ask('Last name'), 'lastname', ['required'], fn () => $this->options['lastname'] = null),
            'email' => $this->validateInput(fn () => $this->options['email'] ?? $this->ask('Email address'), 'email', ['required', 'email', 'unique:' . $this->getUserModel()], fn () => $this->options['email'] = null),
            'password' => Hash::make($this->validateInput(fn () => $this->options['password'] ?? $this->secret('Password'), 'password', ['required', 'min:8'], fn () => $this->options['password'] = null)),
        ];
    }
}
