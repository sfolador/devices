<?php

declare(strict_types=1);

namespace Sfolador\Devices\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Sfolador\Devices\Models\Device;

trait HasDevices
{
    public function devices(): MorphMany
    {
        return $this->morphMany(Device::class, 'notifiable');
    }
}
