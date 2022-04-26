<?php

namespace App\Services\Auth\Contract;

use App\Models\Active_code;
use App\Models\User;
use App\Services\Auth\Notification;

abstract class AuthProvider
{
    public static $instance = null;
    public  $user_model;
    public  $active_code_model;
    public  $notification_model;
    protected $request;


    protected function __construct()
    {
        global $request;
        $this->request = $request;
        $this->user_model = new User();
        $this->active_code_model = new Active_code();
        $this->notification_model = new Notification();
    }

    public static function instance()
    {
        if (is_null(static::$instance)) {
            //یک شی از همین کلاس ساخته می‌شود
            static::$instance = new static(new User());
        }
        return static:: $instance;
    }




    // public abstract function register(array $data);
    public abstract function login(array $param, bool $is_admin = false);
    public abstract function is_login(); //id user
    public abstract function is_token($token); //id user
    public abstract function logout();



    public function generate_hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function generate_random_password()
    {
        $alphabet    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass        = array();                                                           //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1;                                             //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
                  $n = rand(0, $alphaLength);
            $pass[]  = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function is_valid_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function is_valid_phone($phone)
    {
        $pattern = '/^09(1[0-9]|3[1-9]|2[1-9])-?[0-9]{3}-?[0-9]{4}/';
        return preg_match($pattern, $phone);
    }

    public function is_strong_password($password)
    {
        if (strlen($password) < 6) {
            return false;
        }
        // add validation
        return true;
    }
}
