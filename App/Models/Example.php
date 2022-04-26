<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;
use App\Utilities\FlashMessage;

class Example extends MysqlBaseModel
{
    protected $table = 'examples';

    public function create_example($params)
    {
        return $this->create($params);
    }

    public function read_example($id=null)
    {
        if (is_null($id)) {
            return $this->all();
        }
        return $this->first(['id' => $id]);
    }

    public function update_example($params ,$id)
    {
        return $this->update($params, ['id' => $id]);
    }

    public function delete_example($id)
    {
        return $this->delete(['id' => $id]);
    }
}

