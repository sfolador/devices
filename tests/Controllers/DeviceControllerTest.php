<?php

use function Pest\Laravel\post;
use Sfolador\Devices\Enums\DevicePlatform;
use Sfolador\Devices\Enums\DeviceType;
use Sfolador\Devices\Models\Device;
use Sfolador\Devices\Tests\TestSupport\Models\TestNotifiable;

it('can create a device', function () {
    $deviceRequest = [
        'platform' => DevicePlatform::ANDROID->value,
        'type' => DeviceType::MOBILE->value,
        'token' => fake()->uuid,
    ];

    $response = post(route('devices:store'), $deviceRequest);
    $response->assertOk();

    $device = $response->json();
    expect($device['platform'])
        ->toBe($deviceRequest['platform'])
        ->and($device['type'])
        ->toBe($deviceRequest['type'])
        ->and($device['token'])
        ->toBe($deviceRequest['token']);

    $this->assertDatabaseHas('devices', $deviceRequest);
});

it('cannot create a device with no token', function () {
    $deviceRequest = [
        'platform' => DevicePlatform::ANDROID->value,
        'type' => DeviceType::MOBILE->value,
    ];

    $response = post(route('devices:store'), $deviceRequest);
    $response->assertInvalid('token');
});

it('cannot create a device with no platform', function () {
    $deviceRequest = [
        'type' => DeviceType::MOBILE->value,
        'token' => fake()->uuid,
    ];

    $response = post(route('devices:store'), $deviceRequest);
    $response->assertInvalid('platform');
});

it('cannot create a device with no type', function () {
    $deviceRequest = [
        'platform' => DevicePlatform::ANDROID->value,
        'token' => fake()->uuid,
    ];

    $response = post(route('devices:store'), $deviceRequest);
    $response->assertInvalid('type');
});

it('can attach a device', function () {
    $device = Device::factory()->ios()->create();
    $user = TestNotifiable::factory()->create();
    loginAsUser($user);

    expect($device->notifiable)->toBeNull();

    $response = post(route('devices:attach'), [
        'token' => $device->token,
        'platform' => $device->platform->value,
        'type' => $device->type->value,
    ]);

    $response->assertOk();

    expect($device->fresh()->notifiable)
        ->toBeInstanceOf(TestNotifiable::class)
        ->and($device->fresh()->notifiable->id)
        ->toBe($user->id);
});

it('can create and attach a device at the same time', function () {
    $deviceRequest = [
        'token' => fake()->iosMobileToken,
        'platform' => fake()->randomElement(DevicePlatform::cases())->value,
        'type' => fake()->randomElement(DeviceType::cases())->value,
    ];
    $user = TestNotifiable::factory()->create();
    loginAsUser($user);

    $response = post(route('devices:attach'), $deviceRequest);

    $response->assertOk();

    $device = Device::where('token', $deviceRequest['token'])
        ->where('platform', $deviceRequest['platform'])
            ->where('type', $deviceRequest['type'])->first();

    expect($device->fresh()->notifiable)
        ->toBeInstanceOf(TestNotifiable::class)
        ->and($device->fresh()->notifiable->id)
        ->toBe($user->id);
});
