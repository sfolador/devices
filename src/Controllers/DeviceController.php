<?php

declare(strict_types=1);

namespace Sfolador\Devices\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Sfolador\Devices\Actions\AttachDevice;
use Sfolador\Devices\Data\DeviceData;

class DeviceController extends Controller
{
    public function attach(DeviceData $deviceData): JsonResponse
    {
        $device = AttachDevice::execute($deviceData, auth()->user());

        return response()->json($device);
    }
}
