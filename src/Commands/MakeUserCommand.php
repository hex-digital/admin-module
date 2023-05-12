<?php

declare(strict_types=1);

namespace HexDigital\AdminModule\Commands;

use Filament\Commands\MakeUserCommand as Command;
use Illuminate\Support\Facades\Hash;

class MakeUserCommand extends Command
{
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
