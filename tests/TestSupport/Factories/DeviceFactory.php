<?php

namespace Sfolador\Devices\Tests\TestSupport\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sfolador\Devices\Enums\DevicePlatform;
use Sfolador\Devices\Enums\DeviceType;
use Sfolador\Devices\Models\Device;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(DeviceType::cases()),
            'platform' => $this->faker->randomElement(DevicePlatform::cases()),
            'token' => $this->faker->uuid,
            'notifiable_id' => null,
            'notifiable_type' => null,
        ];
    }

    public function ios(): DeviceFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'platform' => DevicePlatform::IOS,
                'type' => DeviceType::MOBILE,
            ];
        });
    }

    public function android(): DeviceFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'platform' => DevicePlatform::ANDROID,
                'type' => DeviceType::MOBILE,
            ];
        });
    }

    public function web(): DeviceFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'platform' => DevicePlatform::WEB,
            ];
        });
    }
}
