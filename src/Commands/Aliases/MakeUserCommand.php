<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Commands\Aliases;

use HexDigital\ApiConsoleModule\Commands\MakeUserCommand as Command;

final class MakeUserCommand extends Command
{
    protected $hidden = true;

    protected $signature = 'filament:user';
}
