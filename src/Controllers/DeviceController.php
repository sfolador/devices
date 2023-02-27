<?php
declare(strict_types=1);

namespace Sfolador\Devices\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Sfolador\Devices\Models\Device;
use Sfolador\Devices\Requests\DeviceRequest;

class DeviceController extends Controller
{
    public function store(DeviceRequest $deviceRequest): JsonResponse
    {
        $device = new Device();
        $device->fill((array) $deviceRequest->validated());

        $device->save();

        return response()->json($device);
    }

    public function attach(DeviceRequest $deviceRequest): JsonResponse
    {
        $device = Device::where('token', $deviceRequest->string('token'))->first();
        if (! $device) {
            $device = new Device();
            $device->fill((array) $deviceRequest->validated());
        }

        $device->notifiable()->associate($deviceRequest->user());
        $device->save();

        return response()->json($device);
    }
}
