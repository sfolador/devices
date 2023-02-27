<?php

use Sfolador\Devices\Models\Device;
use Sfolador\Devices\Tests\TestSupport\Models\TestNotifiable;

it('can have devices', function () {
    $testNotifiable = TestNotifiable::factory()->create();
    Device::factory(4)->create(['notifiable_id' => $testNotifiable->id, 'notifiable_type' => TestNotifiable::class]);
    expect($testNotifiable->devices)->toHaveCount(4);
});
