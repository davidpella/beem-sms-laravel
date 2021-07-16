# Beem SMS notifications channel for Laravel

This package makes it easy to send Beem SMS notifications with Laravel 8.x

Sending an SMS to a user becomes as simple as using:

```php
use App\Notifications\AccountCreated;
 
$user->notify(new AccountCreated);
```

Or on-demand notifications

```php
use App\Notifications\AccountCreated;
use Illuminate\Support\Facades\Notification;

Notification::route("beem-sms", "255762000000")->notify(new AccountCreated);
```

## Installation

You can install the package via composer:

```shell
composer require davidpella/beem-sms-laravel
```

##  Configuration

Add your Beem Account api_key, api_secret, and source_address to your .env:

```dotenv
BEEM_SMS_SOURCE_ADDRESS=
BEEM_SMS_API_KEY=
BEEM_SMS_SECRET_KEY=
```

## Advanced configuration

Run to public configuration file `config` directory

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

    public function via($notifiable):array
    {
        return [BeemSmsChannel::class]; // or ["beem-sms"]
    }

    public function toBeemSms($notifiable):BeemSmsMessage
    {
        return (new BeemSmsMessage())
            ->content("Your {$notifiable->name} account was created!");
    }
}
```

In order to let your Notification know which phone are you sending to, the channel will look for the `phone` attribute of the Notifiable model. 

If you want to override this behaviour, add the `routeNotificationForBeemSms` method to your Notifiable model.

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    
    public function routeNotificationForBeemSms()
    {
        return $this->phone_number;
    }
}

```

Or

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    
    public function routeNotificationForBeemSms()
    {
        return "255762000000";
    }
}

```

## Available message methods

To use the Beem Sms Client Library you can use the facade:

```php
use DavidPella\BeemSms\Facades\BeemSms;

BeemSms::send([
    "recipient" => "255762000000",
    "message" => "Using the facade to send a message.",
]);
```

Or request the instance from the service container

```php
app("DavidPella\BeemSms\BeemSmsClient")
    ->recipient("255762000000")
    ->message("Send sms message using laravel service container")
    ->dispatch();
```

## Testing
```shell 
composer test
```

## Changelog
Please see [CHANGELOG](https://github.com/davidpella/beem-sms-laravel/blob/master/CHANGELOG.md) for more information on what has changed recently.



