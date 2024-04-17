<?php

namespace Brackets\LaravelModuleComposerPackage\Commands;

use Illuminate\Console\Command;

class LaravelModuleComposerPackageCommand extends Command
{
    public $signature = 'laravel-module-composer-package';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
