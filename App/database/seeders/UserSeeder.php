<?php

namespace App\database\seeders;

use App\Models\Contracts\MysqlBaseModel;
use Faker\Factory;

class UserSeeder
{
    // use the factory to create a Faker\Generator instance

    public function seedUser()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $values = [
                [
                    'first_name'    => $faker->firstName,
                    'last_name'     => $faker->firstNameFemale,
                    'national_code' => $faker->p,
                    'postal_code'   => rand(1000000000, 999999999),
                    'address'       => $faker->address,
                    'email'         => $faker->email,
                ],

            ];

            foreach ($values as $value) {
                $obj = new MysqlBaseModel();
                $obj->create($value);
            }
        }
    }
}
