<?php

namespace Sfolador\Devices\Actions;

use Illuminate\Foundation\Auth\User;
use Sfolador\Devices\Models\Device;
use Sfolador\Devices\Requests\DeviceRequest;

class AttachDevice
{
    public static function execute(DeviceRequest $request, ?User $user): Device
    {
        // ray($request);
        $validated = (array)$request->validated();
        $device = Device::where('token', $validated['token'])->first();
        if (! $device) {
            $device = new Device();
            $device->fill((array) $request->validated());
        }

        if ($user) {
            $device->notifiable()->associate($user);
        }

        $device->save();

        return $device;
    }
}
