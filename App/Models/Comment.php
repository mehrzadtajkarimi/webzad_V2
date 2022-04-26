<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;

class Comment extends MysqlBaseModel
{
    protected $table = 'comments';

    public function create_comment(array $params)
    {
        return $this->create($params);
    }
    public function read_comment($id = null)
    {
        if (is_null($id)) {
            return $this->all();
        }
        return $this->find_by_id($id);
    }
    public function read_comment__by__user_id_entity_type($user_id, $entity_type, $id = false)
    {
        if ($id) {
            return $this->get_all([
                'id'          => $id,
                'user_id'     => $user_id,
                'entity_type' => $entity_type,
            ]) ?? false;
        }

        return $this->get_all([
            'user_id'     => $user_id,
            'entity_type' => $entity_type,
        ]) ?? false;
    }
    public function read_comment_replies($comment_id, $blog_id, $entity_type)
    {
        return $this->get('*', [
            'entity_type' => $entity_type,
            'entity_id'   => $blog_id,
            'parent_id'   => $comment_id,
        ])[0] ?? [];
    }

    public function update_comment(array $params, $id)
    {
        return $this->update($params, ['id' => $id]);
    }
    public function status_down(array $param, $id)
    {
        return $this->update($param, ['id' => $id]);
    }
    public function status_up(array $params, $id)
    {
        return $this->update($params, ['id' => $id]);
    }

    public function delete_comment($id)
    {
        return $this->delete(['id' => $id]);
    }


    public function join_all_comment_to_user_by_comment_id($id = null)
    {
        return  $this->connection->query("
        SELECT
        *
        FROM users
        INNER JOIN comments
        ON  users.id=comments.user_id
        WHERE comments.id =$id
        ORDER BY
        comments.id DESC
        ")->fetchAll();
    }
    public function join_all_comment_to_user_by_comment_parent_id($parent_id = null)
    {
        return  $this->connection->query("
        SELECT
        *
        FROM users
        INNER JOIN comments
        ON  users.id=comments.user_id
        WHERE comments.parent_id =$parent_id
        ORDER BY
        comments.id DESC
        ")->fetchAll();
    }
}
