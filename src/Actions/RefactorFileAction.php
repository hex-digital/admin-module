<?php

declare(strict_types=1);

namespace HexDigital\AdminModule\Actions;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

final class RefactorFileAction
{
    public function __construct(
        protected Filesystem $files,
    ) {
    }

    public function execute(string $path, array $refactors): void
    {
        $contents = $this->files->get(path: $path);

        $this->files->put(
            path: $path,
            contents: Str::of($contents)
                ->replace(
                    search: array_keys(array: $refactors),
                    replace: $refactors,
                )
                ->toString(),
        );
    }
}
