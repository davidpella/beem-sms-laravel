# Beem SMS notifications channel for Laravel

This package makes it easy to send Twilio notifications (opens new window)with Laravel 8.x

## Installation

You can install the package via composer:

```shell
composer require davidpella/beem-sms
```

##  Configuration

Add your Beem Account api_key, api_secret, and source_address to your .env:

```dotenv
BEEM_SMS_SOURCE_ADDRESS=
BEEM_SMS_API_KEY=
BEEM_SMS_SECRET_KEY=
```

## Advanced configuration

Run 
```shell
php artisan vendor:publish --provider="DavidPella\BeemSms\BeemSmsServiceProvider"
```

## Usage

Now you can use the channel in your via() method inside the notification:

```php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use DavidPella\BeemSms\Channel\BeemSmsChannel;
use Illuminate\Notifications\Notification;
use DavidPella\BeemSms\Channel\BeemSmsMessage;

class AccountCreated extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [BeemSmsChannel::class]; // or ["beem-sms"]
    }

    public function toBeemSms($notifiable)
    {
        return (new BeemSmsMessage())
            ->content("Your {$notifiable->name} account was created!");
    }
}
```

In order to let your Notification know which phone are you sending to, the channel will look for the `phone` attribute of the Notifiable model. If you want to override this behaviour, add the routeNotificationForBeemSms method to your Notifiable model.

```php
public function routeNotificationForBeemSms()
{
    return "255762000000";
}
```

## Available Message methods

BeemSmsMessage  `content('Message body')`: Accepts a string value for the notification body.

To use the Beem Sms Client Library you can use the facade, or request the instance from the service container:

```php
BeemSms::sendMessage([
    "recipient" => "255762000000",
    "message" => "Using the facade to send a message.",
]);
```

Using Facade

```php
BeemSms::recipient("255762764819")
    ->message("Using the facade to send a message.")
    ->send();
```

Using instance

```php
(new BeemSmsClient())
    ->recipient("255762000000")
    ->message("Using the facade to send a message.")
    ->send();
```

