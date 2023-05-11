<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Commands\Aliases;

use HexDigital\ApiConsoleModule\Commands;

class MakeUserCommand extends Commands\MakeUserCommand
{
    protected $hidden = true;

    protected $signature = 'filament:user';
}
