<?php

namespace App\Controllers;

use App\Utilities\Lang;

class Controller
{
    protected $request;

    public function __construct()
    {
        global $request;
        $this->request = $request;
    }

    public function model($model_name)
    {
        $model_full_name = 'App\Models\\' . ucfirst($model_name);
        if (class_exists($model_full_name)) {
            return new $model_full_name;
        }
        return null;
    }


    public function str_rtrim($string, $param)
    {
        return array_shift(explode($param, $string));
    }

    public static function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function convert_numbers($ln, $input)
    {
        $lang = new Lang;
        if ($ln == 'fa') {
            return $lang->convertEnglishNumbersToPersian($input);
        }
        if ($ln == 'en') {
            return $lang->convertPersianNumbersToEnglish($input);
        }
    }
}
