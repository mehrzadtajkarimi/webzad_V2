<?php
namespace App\Utilities;

class Tinyint{

    static function  category_robots()
    {
        return array(
			'index',
			'noindex',
			'nofollow',
			'follow',
			'none',
			'noimageindex',
			'noarchive',
			'nocache',
			'index, follow',
			'noindex, nofollow',
			'index, nofollow',
			'noindex, follow'
		);
    }
}
