<?php

namespace App\database\seeders;

use App\Models\Permission;

class PermissionSeeder
{


    public function seedPermissions()
    {
        // $permissionModel = new Permission();
        $params =  array(
            

            #category
            [
                'name' =>  "category-read",
                'label' => "نمایش دسته بندی ها",
            ],
            [
                'name' =>  "category-update",
                'label' => "ویرایش دسته بندی ها",
            ],
            [
                'name' =>  "category-create",
                'label' => "ایجاد دسته بندی ها",
            ],
            [
                'name' =>  "category-delete",
                'label' => "حذف دسته بندی ها",
            ],

           



        );
        foreach ($params as $value) {
            // $permissionModel->create_permission($value);
        }
    }
}
