<?php

declare(strict_types=1);

namespace HexDigital\AdminModule\Tests;

use Filament\FilamentServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use HexDigital\AdminModule\AdminModuleServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            FilamentServiceProvider::class,
            AdminModuleServiceProvider::class,
        ];
    }
}
