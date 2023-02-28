<?php

namespace Sfolador\Devices\Actions;

use Illuminate\Foundation\Auth\User;
use RuntimeException;
use Sfolador\Devices\Data\DeviceData;
use Sfolador\Devices\Models\Device;

class AttachDevice
{
    public static function execute(DeviceData $request, ?User $user): Device
    {
        $device = Device::where('token', $request->token)->first();
        if (! $device) {
            $device = new Device();
            $device->fill($request->toArray());
        }

        if ($user) {
            if ($device->notifiable && $device->notifiable->isNot($user) && ! config('devices.allow_device_reassign')) {
                throw new RuntimeException('Device already assigned to another user');
            }

            $device->notifiable()->associate($user);
        }

        $device->save();

        return $device;
    }
}
