<?php

namespace App\Services\Log\Contract;

interface LogContract
{
    /**
     * @param string $key
     * @return mixed
     */
    public static function get(string $key);

    /**
     * @param string $key
     * @param mixed $value
     * @return LogContract
     */
    public static function set($value);

    public static function remove(int $id);

    public static function clean();

    public static function has(int $id);
}
