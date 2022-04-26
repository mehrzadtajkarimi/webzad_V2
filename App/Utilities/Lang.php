<?php

namespace App\Utilities;

class Lang
{
    function convertPersianNumbersToEnglish($input)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '٤', '۵', '٥', '٦', '۶', '۷', '۸', '۹'];
        $english = [0,  1,  2,  3,  4,  4,  5,  5,  6,  6,  7,  8,  9];
        return str_replace($persian, $english, $input);
    }

    function convertEnglishNumbersToPersian($input)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = [0,  1,  2,  3,  4,  5,  6,  7,  8,  9];
        return str_replace($english, $persian, $input);
    }
}
