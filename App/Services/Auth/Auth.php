<?php

namespace App\Services\Auth;

use App\Core\Contracts\Facade;
use App\Services\Auth\Providers\SessionProvider;

class Auth extends Facade
{
    protected static $provider;

    public static function set_provider()
    {
        self::$provider = SessionProvider::instance();
    }
}


