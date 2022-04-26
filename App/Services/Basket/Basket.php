<?php

namespace App\Services\Basket;

use App\Core\Contracts\Facade;
use App\Services\Basket\Providers\SessionProvider;

class Basket extends Facade
{
    protected static $provider;

    public static function set_provider()
    {
        self::$provider = SessionProvider::instance();
    }
}
