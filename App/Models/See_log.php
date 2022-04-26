<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;
use App\Utilities\FlashMessage;

class See_log extends MysqlBaseModel
{
    protected $table = 'see_log';

    public function create_log($params)
    {
        return $this->create($params);
    }

    public function read_log($id = null)
    {
        if (is_null($id)) {
            return $this->all();
        }
        return $this->first(['id' => $id]);
    }

    public function update_log($params, $id)
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

    public function comparison($as, $to, $user_id = false)
    {
        if ($user_id) {
            return  $this->connection->count($this->table, '*', [
                "created_at[<>]" => [$as, $to],
                'user_id[>]'     => 0,
                'GROUP'          => [
                    'user_id',
                ],
            ]);
        }
        return  $this->connection->count($this->table, '*', [
            "created_at[<>]" => [$as, $to],
            'user_id'     => 0,
        ]);
    }
}
