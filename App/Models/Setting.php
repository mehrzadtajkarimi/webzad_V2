<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;

class Setting extends MysqlBaseModel
{
    protected $table = 'settings';

    public function create_setting( array $params)
    {
        return $this->create($params);
    }
    public function read_setting($id=null)
    {
        if (is_null($id)) {
            return $this->all();
        }
        return $this->find_by_id($id);
    }
    public function get_setting($key)
    {
		$rows=$this->get('value',['key'=>$key]);
		if (isset($rows[0])) return [0];
    }
    public function read_setting_by_slug($slug=null)
    {
        if (is_null($slug)) {
            return false;
        }
        return $this->get('*',['slug'=>$slug]);
    }
    public function read_setting_by_key($key=null)
    {
        if (is_null($key)) {
            return $this->all();
        }
        return $this->get('*',['key'=>$key]);
    }
    public function update_setting(array $params , $id)
    {
        return $this->update($params, ['id' => $id]);
    }

    public function delete_setting($id)
    {
        return $this->delete(['id' => $id]);
    }




}