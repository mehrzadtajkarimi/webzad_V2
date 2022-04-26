<?php

namespace App\Services\Log;

use App\Models\Activity_log;
use App\Models\See_log;
use App\Services\Log\Contract\LogContract;

class LogManager implements LogContract
{
    private static $activityLogModel;
    private static $seeLogModel;

    public function __construct()
    {

        self::$activityLogModel = new Activity_log();
        self::$seeLogModel = new See_log();
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        if (self::has($key)) {
            return self::$activityLogModel->read_log($key);
        }

        return null;
    }

    public static function set_see_log($value)
    {
        self::$seeLogModel->create_log($value);
        return new self;
    }

    public static function set($value)
    {
        self::$activityLogModel->create_log($value);
        return new self;
    }

    public static function remove(int $id)
    {
        if (self::has($id)) {
            self::$activityLogModel->delete_log($id);
            return true;
        }
        return false;
    }

    public static function clean()
    {
        self::$activityLogModel->clean_log();
    }

    public static function has(int $id)
    {
        return self::$activityLogModel->read_log($id);
    }
}
