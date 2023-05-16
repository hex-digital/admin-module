<?php

declare(strict_types=1);

namespace HexDigital\AdminModule\Commands\Aliases;

use HexDigital\AdminModule\Commands\MakeUserCommand as Command;

class MakeUserCommand extends Command
{
    protected $hidden = true;

    protected $signature = 'filament:user';
}
