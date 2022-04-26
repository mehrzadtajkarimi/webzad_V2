<?php

namespace App\Utilities;

class Asset
{

    public static function __callStatic($route, $file_name)
    {
        return BASEPATH . 'assets/' . $route . '/' . implode(',', $file_name);
    }
}
