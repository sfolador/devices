<?php

namespace Sfolador\Devices\Tests\TestSupport;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use Sfolador\Devices\DevicesServiceProvider;
use Spatie\LaravelData\LaravelDataServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Sfolador\\Devices\\Tests\\TestSupport\\Factories\\'.class_basename($modelName).'Factory'
        );
        $this->runMigrations();
    }

    protected function getPackageProviders($app)
    {
        return [
            DevicesServiceProvider::class,
            LaravelDataServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testbench');
        config()->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);


        Schema::create('testnotifiables', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email');

            $table->timestamps();
        });
    }

    protected function runMigrations(): void
    {
        // Include and run each migration manually to ensure they execute
        $migrations = [
            include __DIR__ . '/../../database/migrations/create_devices_table.php',
            include __DIR__ . '/../../database/migrations/add_firebasetoken_devices_table.php',
            include __DIR__ . '/../../database/migrations/add_indexes_for_tokens.php',
        ];

        // Run each migration
        foreach ($migrations as $migration) {
            $migration->up();
        }
    }
}
