<?php

use Sfolador\Devices\Actions\AttachDevice;
use Sfolador\Devices\Data\DeviceData;
use Sfolador\Devices\Enums\DevicePlatform;
use Sfolador\Devices\Enums\DeviceType;
use Sfolador\Devices\Models\Device;
use Sfolador\Devices\Tests\TestSupport\Models\TestNotifiable;

it('can create a device', function () {
    $requestParams = [
        'platform' => DevicePlatform::ANDROID->value,
        'type' => DeviceType::MOBILE->value,
        'token' => fake()->uuid,
    ];

    $request = DeviceData::from($requestParams);

    $device = AttachDevice::execute($request, null);

    expect($device)->toBeInstanceOf(Device::class)
        ->and($device->platform->value)
        ->toBe($requestParams['platform'])
        ->and($device->type->value)
        ->toBe($requestParams['type'])
        ->and($device->token)
        ->toBe($requestParams['token']);
});

it('can attach a device to a user', function () {
    $user = TestNotifiable::factory()->create();
    loginAsUser($user);

    $requestParams = [
        'platform' => DevicePlatform::ANDROID->value,
        'type' => DeviceType::MOBILE->value,
        'token' => fake()->uuid,
    ];

    $request = DeviceData::from($requestParams);

    $device = AttachDevice::execute($request, $user);

    expect($device)->toBeInstanceOf(Device::class)
        ->and($device->platform->value)
        ->toBe($requestParams['platform'])
        ->and($device->type->value)
        ->toBe($requestParams['type'])
        ->and($device->token)
        ->toBe($requestParams['token'])
        ->and($device->notifiable)
        ->toBeInstanceOf(TestNotifiable::class)
        ->and($device->notifiable)
        ->id->toBe($user->id);
});

it('cannot attach a device to a user if device already attached to another user', function () {
    $user = TestNotifiable::factory()->create();
    $anotherUser = TestNotifiable::factory()->create();

    $requestParams = [
        'platform' => DevicePlatform::ANDROID->value,
        'type' => DeviceType::MOBILE->value,
        'token' => fake()->uuid,
    ];

    $device = Device::factory()->create($requestParams);
    $device->notifiable()->associate($anotherUser);
    $device->save();

    loginAsUser($user);

    $request = DeviceData::from($requestParams);

    $device = AttachDevice::execute($request, $user);
})->throws(RuntimeException::class);

it('can attach a device to a user if device already attached to another user', function () {
    config()->set('devices.allow_device_reassign', true);

    $user = TestNotifiable::factory()->create();
    $anotherUser = TestNotifiable::factory()->create();

    $requestParams = [
        'platform' => DevicePlatform::ANDROID->value,
        'type' => DeviceType::MOBILE->value,
        'token' => fake()->uuid,
    ];

    $device = Device::factory()->create($requestParams);
    $device->notifiable()->associate($anotherUser);
    $device->save();

    loginAsUser($user);

    $request = DeviceData::from($requestParams);

    $device = AttachDevice::execute($request, $user);

    expect($device->notifiable->id)->toBe($user->id);
});
