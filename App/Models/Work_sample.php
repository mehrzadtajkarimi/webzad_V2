<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;
use App\Utilities\FlashMessage;

class Work_sample extends MysqlBaseModel
{
    protected $table = 'work_samples';

    public function create_work_sample($params)
    {
        return $this->create($params);
    }

    public function read_work_sample($type = null)
    {
        return $this->select('*',['type' => $type]);
    }

    public function update_work_sample($params, $id)
    {
        return $this->update($params, ['id' => $id]);
    }

    public function delete_work_sample($id)
    {
        return $this->delete(['id' => $id]);
    }
}
