<?php

declare(strict_types=1);

namespace Sfolador\Devices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Sfolador\Devices\Enums\DevicePlatform;
use Sfolador\Devices\Enums\DeviceType;

/**
 * @property string $name
 * @property DeviceType $type
 * @property DevicePlatform $platform
 * @property string $token
 * @property string $firebaseToken
 */
class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'platform',
        'token',
        'notifiable_id',
        'notifiable_type',
        'firebaseToken'
    ];

    protected $casts = [
        'type' => DeviceType::class,
        'platform' => DevicePlatform::class,
    ];

    /**
     * @return MorphTo<Model,Device>
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
