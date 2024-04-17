<?php

namespace Brackets\LaravelModuleComposerPackage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Brackets\LaravelModuleComposerPackage\LaravelModuleComposerPackage
 */
class LaravelModuleComposerPackage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Brackets\LaravelModuleComposerPackage\LaravelModuleComposerPackage::class;
    }
}
