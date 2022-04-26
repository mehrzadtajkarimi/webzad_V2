<?php

namespace App\Services\Validation;

use App\contracts\Facade;
use App\Services\Validation\providers\SmsProvider;

class validation extends Facade
{
    protected static $provider;

    public static function set_provider()
    {
        self::$provider = SmsProvider::instance();
    }
}
