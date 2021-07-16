<?php

namespace DavidPella\BeemSms\Facades;

use Illuminate\Support\Facades\Facade;

class BeemSms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'beem-sms';
    }
}
