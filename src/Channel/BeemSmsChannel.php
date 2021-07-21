<?php

namespace DavidPella\BeemSms\Channel;

use DavidPella\BeemSms\Exceptions\CouldNotSendNotificationException;
use Illuminate\Notifications\Notification;

class BeemSmsChannel
{
    /**
     * @param $notifiable
     * @param Notification $notification
     *
     * @throws CouldNotSendNotificationException
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toBeemSms($notifiable);

        $recipient = $this->getIdentification($notification, $notifiable);

        if (!$message instanceof BeemSmsMessage) {
            throw new CouldNotSendNotificationException('Invalid Message Object');
        }

        if ($recipient) {
            $message->recipient($recipient)->send();
        }
    }

    /**
     * @param Notification $notification
     * @param $notifiable
     *
     * @throws CouldNotSendNotificationException
     *
     * @return mixed
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

        throw new CouldNotSendNotificationException('Invalid Recipient');
    }
}
