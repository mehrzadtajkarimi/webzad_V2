<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;

class Active_code extends MysqlBaseModel
{
    protected $table = 'active_codes';


    public function create_active_code(array $params)
    {
        return $this->create($params);
    }
    public function read_active_code($id = null)
    {
        if (is_null($id)) {
            return $this->all();
        }
        return $this->first(['id' => $id]);
    }
    public function update_active_code(array $params, $id)
    {
        return $this->update($params, $id);
    }
    public function get_expired_at($user_id)
    {
        $expired_at = $this->get('expired_at', ['user_id' => $user_id]);

        return $expired_at[0];
    }
    public function is_code($token, $user_id)
    {
        $code = $this->select(
            ['code', 'expired_at'],
            [
                'user_id' => $user_id,
                'ORDER'   => ['expired_at'=>'DESC'],
                'LIMIT'   => 1
            ]
        );
        return $code[0]['code'] == $token ? true : false;
    }
}
