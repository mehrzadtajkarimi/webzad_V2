<?php

namespace App\Services\Session\Contract;

interface SessionContract
{
    /**
     * @param string $key
     * @return mixed
     */
    public static function get(string $key);

    /**
     * @param string $key
     * @param mixed $value
     * @return SessionInterface
     */
    public static function set(string $key, $value): self;

    public static function remove(string $key): bool;

    public static function clear(): void;

    public static function has(string $key): bool;
}
