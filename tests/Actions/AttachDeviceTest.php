<?php

use Illuminate\Http\Request;
use Sfolador\Devices\Actions\AttachDevice;
use Sfolador\Devices\Enums\DevicePlatform;
use Sfolador\Devices\Enums\DeviceType;
use Sfolador\Devices\Models\Device;
use Sfolador\Devices\Requests\DeviceRequest;

//
//it('can create a device',function(){
//    $requestParams = [
//        'platform' => DevicePlatform::ANDROID->value,
//        'type' => DeviceType::MOBILE->value,
//        'token' => fake()->uuid,
//    ];
//
//    ;
//
//    $request = DeviceRequest::createFrom(new Request($requestParams));
//
//    $device = AttachDevice::execute($request, null);
//
//    expect($device)->toBeInstanceOf(Device::class)
//        ->and($device->platform)
//        ->toBe($requestParams['platform'])
//        ->and($device->type)
//        ->toBe($requestParams['type'])
//        ->and($device->token)
//        ->toBe($requestParams['token']);
//
//});
//
//it('can attach a device to a user');
