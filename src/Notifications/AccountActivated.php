<?php

namespace DavidPella\BeemSms\Notifications;

use DavidPella\BeemSms\Channel\BeemSmsMessage;
use Illuminate\Notifications\Notification;

class AccountActivated extends Notification
{
    public function via($notifiable): array
    {
        return ['beem-sms'];
    }

    public function toBeemSms($notifiable): BeemSmsMessage
    {
        return (new BeemSmsMessage())
            ->content("Hello {$notifiable->name}, Your account was created!");
    }
}
