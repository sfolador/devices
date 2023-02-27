<?php

declare(strict_types=1);

namespace Sfolador\Devices\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Sfolador\Devices\Enums\DevicePlatform;
use Sfolador\Devices\Enums\DeviceType;

class DeviceRequest extends FormRequest
{
    /**
     * @return array<string, string|array<string|Enum>>
     */
    public function rules(): array
    {
        return [
            'platform' => ['required', new Enum(DevicePlatform::class)],
            'type' => ['required', new Enum(DeviceType::class)],
            'token' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
