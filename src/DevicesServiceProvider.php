<?php

declare(strict_types=1);

namespace Sfolador\Devices;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DevicesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('devices')
            ->hasConfigFile('devices')
            ->hasRoutes('devices_routes')
            ->hasMigrations(
                ['create_devices_table',
                    'add_firebasetoken_devices_table',
                    'add_indexes_for_tokens']);

    }

    public function registeringPackage(): void
    {
        parent::registeringPackage(); // TODO: Change the autogenerated stub

    }
}
