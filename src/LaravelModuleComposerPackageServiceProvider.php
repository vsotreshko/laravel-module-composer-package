<?php

namespace Brackets\LaravelModuleComposerPackage;

use Brackets\LaravelModuleComposerPackage\Commands\LaravelModuleComposerPackageCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelModuleComposerPackageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-module-composer-package')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-module-composer-package_table')
            ->hasCommand(LaravelModuleComposerPackageCommand::class);
    }
}
