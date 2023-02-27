<?php

namespace Sfolador\Devices\Tests\TestSupport\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sfolador\Devices\Tests\TestSupport\Models\TestNotifiable;

class TestNotifiableFactory extends Factory
{
    protected $model = TestNotifiable::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];
    }
}
