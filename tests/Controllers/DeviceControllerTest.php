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
