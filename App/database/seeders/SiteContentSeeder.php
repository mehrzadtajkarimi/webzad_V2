<?php

namespace App\database\seeders;

use App\Models\Setting;
use App\Models\SiteContent;


class SiteContentSeeder
{


    public function seedSiteContents()
    {
        $objects = [


            [
                'tag' => 'contact_info',
                'key' => 'trade',
                'value' => 'همه روزه حتی در ایام تعطیل',
            ],
          
        ];

        foreach ($objects as $object) {
            // $obj = new Setting();
        }
    }
}
