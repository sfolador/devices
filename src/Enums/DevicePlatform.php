<?php

declare(strict_types=1);

namespace Sfolador\Devices\Enums;

enum DevicePlatform: string
{
    case ANDROID = 'android';
    case IOS = 'ios';
    case WEB = 'web';
}
