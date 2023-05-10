<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Tests;

use Filament\FilamentServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use HexDigital\ApiConsoleModule\ApiConsoleModuleServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            FilamentServiceProvider::class,
            ApiConsoleModuleServiceProvider::class,
        ];
    }
}
