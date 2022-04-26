<?php

namespace App\Core\Contracts;

abstract class Facade
{

    protected static function set_provider(){
        throw new \RuntimeException('Facade dose not implemented set provider method');
    }
    public static function __callStatic($name , $arguments)
    {
        static::set_provider();
        // مثلا متذ های داخل  سشن فراخانی می شود
        return (static::$provider)->$name(... $arguments);
    }
}
