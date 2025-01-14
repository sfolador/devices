<?php

namespace Sfolador\Devices\Data;

use Illuminate\Validation\Rules\Enum;
use Sfolador\Devices\Enums\DevicePlatform;
use Sfolador\Devices\Enums\DeviceType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class DeviceData extends Data
{
    public function __construct(
        public string $platform,
        public string $type,
        public string $token,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'platform' => ['required', new Enum(DevicePlatform::class)],
            'type' => ['required', new Enum(DeviceType::class)],
            'token' => 'required|string',
        ];
    }
}
