<?php

declare(strict_types=1);

namespace Sfolador\Devices\Notifications;

use Illuminate\Http\Client\Response;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class FirebasePushNotification extends Notification
{
    public function __construct(public string $title, public string $message)
    {
    }

    /**
     * @param  mixed  $notifiable
     * @return array<string>
     */
    public function via($notifiable): array
    {
        return ['firebase'];
    }

    /**
     * @param  mixed  $notifiable
     */
    public function toFirebase($notifiable): Response|null
    {
        /* @phpstan-ignore-next-line */
        if ($notifiable->devices->count() == 0) {
            return null;
        }
        /* @phpstan-ignore-next-line */
        $devices = $notifiable->devices->pluck('token')->toArray();

        return (new FirebaseMessage)
            ->withTitle($this->title)
            ->withBody($this->message)
            ->withPriority('high')->asMessage($devices);
    }
}
