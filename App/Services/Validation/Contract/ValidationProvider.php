<?php

namespace App\Services\Validation\contract;

abstract class ValidationProvider
{


    public static $instance = null;


    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}
