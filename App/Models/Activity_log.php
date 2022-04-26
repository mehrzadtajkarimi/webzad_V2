<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;
use App\Utilities\FlashMessage;

class Activity_log extends MysqlBaseModel
{
    protected $table = 'activity_log';

    public function create_log($params)
    {
        return $this->create($params);
    }

    public function read_log($id=null)
    {
        if (is_null($id)) {
            return $this->all();
        }
        return $this->first(['id' => $id]);
    }

    public function update_log($params ,$id)
    {
        return $this->update($params, ['id' => $id]);
    }

    public function delete_log($id)
    {
        return $this->delete(['id' => $id]);
    }

    public function  clean_log()
    {
        return $this->query("TRUNCATE TABLE activity_log");
    }
}

