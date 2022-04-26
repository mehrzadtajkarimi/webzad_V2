<?php

namespace App\database\seeders;

use App\Models\Role;

class RoleSeeder
{


    public function seedRole()
    {
        // $roleModel = new Role;
        $params =  array(
            [
                'name' =>  "manager-user",
                'label' => "مدیریت کاربران",
            ],

        );
        foreach ($params as $value) {
            // $roleModel->create_role($value);
        }
    }
}
