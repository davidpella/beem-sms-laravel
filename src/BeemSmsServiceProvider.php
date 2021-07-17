<?php

namespace DavidPella\BeemSms;

use Illuminate\Support\ServiceProvider;
use DavidPella\BeemSms\Channel\BeemSmsChannel;
use Illuminate\Support\Facades\Notification;

class BeemSmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . "/../config/beem-sms.php" => config_path("beem-sms.php")
        ]);

        Notification::extend('beem-sms', function ($app) {
            return new BeemSmsChannel;
        });
    }

    public function register()
    {
        $this->app->singleton(BeemSmsClient::class, function (){
            return new BeemSmsClient(
                config("beem-sms.api_key"),
                config("beem-sms.secret_key")
            );
        });

        $this->app->bind("beem-sms", function (){
            return new BeemSmsClient(
                config("beem-sms.api_key"),
                config("beem-sms.secret_key"),
            );
        });
    }
}
