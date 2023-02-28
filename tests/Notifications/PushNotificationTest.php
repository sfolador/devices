<?php

use Illuminate\Http\Response;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Sfolador\Devices\Models\Device;
use Sfolador\Devices\Notifications\FirebasePushNotification;
use Sfolador\Devices\Tests\TestSupport\Models\TestNotifiable;

it('can notify a user', function () {
    Event::fake();
    Http::fake([
        'fcm.googleapis.com/fcm/send' => Http::response('ok'),
    ]);

    $user = TestNotifiable::factory()->create();
    $device = Device::factory()->create(['token' => 'token']);
    $device->notifiable()->associate($user);
    $device->save();

    $user->notify(new FirebasePushNotification('title', 'message'));
    Event::assertDispatched(NotificationSent::class);
});

it('does not notify a user without devices', function () {
    Event::fake();
    Http::fake([
        'fcm.googleapis.com/fcm/send' => Http::response('ok'),
    ]);

    $user = TestNotifiable::factory()->create();

    $user->notify(new FirebasePushNotification('title', 'message'));
    Event::assertDispatched(NotificationSent::class, function (NotificationSent $event) {
        return $event->response === null;
    });
});

it('sends requests to Google apis', function () {
    Http::fake([
        'fcm.googleapis.com/fcm/send' => Http::response('ok'),
    ]);
    $user = TestNotifiable::factory()->create();

    $device = Device::factory()->create(['token' => 'token']);
    $device->notifiable()->associate($user);
    $device->save();

    $pushNotification = new FirebasePushNotification('title', 'messaggio');

    $sentNotification = $pushNotification->toFirebase($user);

    expect($sentNotification)
        ->toBeInstanceOf(Illuminate\Http\Client\Response::class)
        ->and($sentNotification->status())
        ->toBe(Response::HTTP_OK);
});

it('sends notifications via firebase', function () {
    $user = TestNotifiable::factory()->create();

    $pushNotification = new FirebasePushNotification('title', 'messaggio');

    expect($pushNotification->via($user))->toBe(['firebase']);
});

//
