<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;
use App\Utilities\FlashMessage;

class User extends MysqlBaseModel
{
    protected $table = 'users';

    public function join_user_to_active_codes($id, $token)
    {
        return $this->inner_join(
            "*",
            "active_codes",
            "id",
            "user_id",
            "users.id=$id",
            "active_codes.code=$token",
        );
    }
    public function already_exists($param)
    {
        if (isset($param['phone'])) {
            return  $this->first(['phone' => $param['phone']]) ?? null;
        }
        if (isset($param['email'])) {
            return $this->first(['email' => $param['email']]) ?? null;
        }
    }
    public function read_user($id = null)
    {
        if (is_null($id)) {
            return $this->get('*', [
                'user_level[>]' => 0
            ]);
        }
        return $this->first(['id' => $id]);
    }
    public function get_user($where)
    {
        return $this->get('*', $where);
    }


    public function delete_user($id)
    {
        return $this->delete(['id' => $id]);
    }

    public function is_admin($user_id = null)
    {
        if (is_null($user_id)) {
            return $this->get('*', [
                'user_level' =>  0
            ]);
        }
        if ($user = $this->first(['id' => $user_id])) {

            return $user['user_level'] == 0 ?: FlashMessage::add("  لطفا از ادمین سایت بخواهید دسترسی به پنل  را برای شما ایجاد کند! ", FlashMessage::WARNING);
        }
    }
    public function get_admin($user_id)
    {
        return $this->first([
            'user_level' => 0,
            'id'         => $user_id
        ]);
    }


    public function update_user(array $params, $id)
    {
        return $this->update($params, ['id' => $id]);
    }

    public function join_user_to_photo(int $user_id)
    {
        /* return $this->inner_join(
            "photos.*,users.*,users.id AS user_id",
            "photos",
            "id",
            "entity_id",
            "users.id=$user_id",
            "photos.entity_type='User'",
        )[0] ??  $this->first(['id' => $user_id]); */
        return $this->query("SELECT usr.*,img.`path`,img.`alt` FROM `users` as usr LEFT JOIN `photos` as img ON img.`entity_type` = 'User' AND img.`entity_id` = usr.`id` AND img.`type` = 0 WHERE usr.`id` = $user_id")[0];
    }
    public function join_user_to_photo_all()
    {
        return $this->query("
        SELECT 
        users.first_name,
        users.last_name,
        users.created_at AS created_at,
        photos.*
        FROM users
        LEFT JOIN photos
        ON photos.entity_type = 'User'
        AND photos.entity_id = users.id
        AND photos.type = 0
        ORDER BY  users.id  DESC
        LIMIT 12
        ");
    }

    public function join__whit_province_city($user_id)
    {
        return $this->inner_join_two(
            "users.*,provinces.name AS province_name ,cities.name AS city_name",
            "cities",
            "city_id",
            "id",
            "provinces",
            "province_id",
            "id",
            "users.user_level>0",
            "users.id=$user_id",
        );
    }
}
