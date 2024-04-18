<?php

namespace Brackets\LaravelModuleComposerPackage;

use Brackets\LaravelModuleComposerPackage\Commands\LaravelModuleComposerPackageCommand;
use Brackets\LaravelModuleComposerPackage\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
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
            ->hasMigrations(['create_orders_table', 'add_permissions_to_orders'])
            ->runsMigrations()
            ->hasCommand(LaravelModuleComposerPackageCommand::class);
    }

    public function packageRegistered()
    {
        Route::macro('craftablePro', function (string $baseUrl = 'admin') {
            Route::middleware('craftable-pro-base-middlewares')->prefix($baseUrl)->group(function () {
                Route::middleware('craftable-pro-auth-middleware')->group(function () {
                    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
                    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
                    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
                    Route::get('orders/edit/{order}', [OrderController::class, 'edit'])->name('orders.edit');
                    Route::match(['put', 'patch'], 'orders/{order}', [OrderController::class, 'update'])->name('orders.update');
                    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
                    Route::post('orders/bulk-destroy', [OrderController::class, 'bulkDestroy'])->name('orders.bulk-destroy');
                });
            });
        });
    }
}
