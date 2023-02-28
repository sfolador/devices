<?php

namespace Sfolador\Devices\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Notifications\RoutesNotifications;
use Sfolador\Devices\Models\Concerns\HasDevices;

class TestNotifiable extends BaseUser
{
    use HasFactory;
    use HasDevices;
    use RoutesNotifications;

    protected $table = 'testnotifiables';

    protected $fillable = [
        'name',
        'email',
    ];
}
