<?php

declare(strict_types=1);

namespace HexDigital\AdminModule\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use SplFileInfo;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'admin-module:publish')]
final class PublishCommand extends Command
{
    protected $signature = 'admin-module:publish {--force : Overwrite any existing files}';

    protected $description = 'Publish all of the admin module resources';

    public function handle(Filesystem $files): void
    {
        $this->call(
            command: 'vendor:publish',
            arguments: [
                '--tag' => 'admin-module-config',
                '--force' => $this->option('force'),
            ],
        );

        // Delete any legacy CSS files (due to asset versioning)
        if ($files->isDirectory(directory: $directory = public_path(path: 'vendor/admin-module/assets'))) {
            collect(value: $files->allFiles(directory: $directory))
                ->reject(fn (SplFileInfo $file) => ! Str::endsWith($file->getFilename(), '.css'))
                ->each(fn (SplFileInfo $file) => $files->delete(paths: [
                    $file->getPathname(),
                ]));
        }

        $this->call(
            command: 'vendor:publish',
            arguments: [
                '--tag' => 'admin-module-assets',
                '--force' => true,
            ],
        );
    }
}
