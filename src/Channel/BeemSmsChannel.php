<?php

namespace DavidPella\BeemSms\Channel;

use Illuminate\Notifications\Notification;
use DavidPella\BeemSms\Exceptions\CouldNotSendNotificationException;

class BeemSmsChannel
{
    /**
     * @param $notifiable
     * @param Notification $notification
     * @throws CouldNotSendNotificationException
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toBeemSms($notifiable);

        $recipient = $this->getIdentification($notification, $notifiable);

        if (! $message instanceof BeemSmsMessage) {
            throw new CouldNotSendNotificationException("Invalid Message Object");
        }

        if ($recipient) {
            $message->recipient($recipient)->send();
        }
    }

    /**
     * @param Notification $notification
     * @param $notifiable
     * @return mixed
     * @throws CouldNotSendNotificationException
     */
    protected function getIdentification(Notification $notification, $notifiable)
    {
        if ($notifiable->routeNotificationFor(self::class, $notification)) {
            return $notifiable->routeNotificationFor(self::class, $notification);
        }

        if ($notifiable->routeNotificationFor('beem-sms', $notification)) {
            return $notifiable->routeNotificationFor('beem-sms', $notification);
        }

        if (isset($notifiable->phone)) {
            return $notifiable->phone;
        }

        throw new CouldNotSendNotificationException("Invalid Recipient");
    }
}
