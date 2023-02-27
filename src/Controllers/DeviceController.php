<?php

declare(strict_types=1);

namespace Sfolador\Devices\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Sfolador\Devices\Actions\AttachDevice;
use Sfolador\Devices\Requests\DeviceRequest;

class DeviceController extends Controller
{
    public function store(DeviceRequest $deviceRequest): JsonResponse
    {
        $device = AttachDevice::execute($deviceRequest, null);

        return response()->json($device);
    }

    public function attach(DeviceRequest $deviceRequest): JsonResponse
    {
        $device = AttachDevice::execute($deviceRequest, auth()->user());

        return response()->json($device);
    }
}
