<?php

use Sfolador\Devices\Enums\DevicePlatform;
use Sfolador\Devices\Enums\DeviceType;
use Sfolador\Devices\Models\Device;
use Sfolador\Devices\Tests\TestSupport\Models\TestNotifiable;

it('can have a type', function () {
    $device = Device::factory()->ios()->create();
    expect($device->type)->toBe(DeviceType::MOBILE);
});

it('can have a platform', function () {
    $device = Device::factory()->android()->create();
    expect($device->platform)->toBe(DevicePlatform::ANDROID);
});

it('can have a name', function () {
    $device = Device::factory()->create(['name' => 'test']);
    expect($device->name)->toBe('test');
});

it('can have a token', function () {
    $device = Device::factory()->ios()->create(['token' => 'test']);
    expect($device->token)->toBe('test');
});

it('can have a firebase token', function () {
    $device = Device::factory()->ios()->create(['firebase_token' => 'test']);
    expect($device->firebase_token)->toBe('test');
});

it('the firebase token can be null', function () {
    $device = Device::factory()->ios()->create(['firebase_token' => null]);
    expect($device->firebase_token)->toBeNull();
});

it('can have a null notifiable', function () {
    TestNotifiable::factory()->create();
    $device = Device::factory()->create();
    expect($device->notifiable)->toBeNull();
});

it('can have a notifiable', function () {
    $notifiable = TestNotifiable::factory()->create();
    $device = Device::factory()->create(['notifiable_id' => $notifiable->id, 'notifiable_type' => get_class($notifiable)]);
    expect($device->notifiable)->not()->toBeNull();
});
