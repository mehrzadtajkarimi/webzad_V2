<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;

class City extends MysqlBaseModel
{
    protected $table = 'cities';

    public function read_city($id = null)
    {
        if (is_null($id)) {
            return $this->all();
        }
        return $this->first(['id' => $id]);
    }

    public function get_city_by_province_id($province_id)
    {
        return $this->get_all(['province_id' => $province_id]);
    }
}
