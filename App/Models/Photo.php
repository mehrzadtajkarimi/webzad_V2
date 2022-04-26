<?php

namespace App\Models;

use App\Models\Contracts\MysqlBaseModel;
use App\Utilities\FlashMessage;

class Photo extends MysqlBaseModel
{
    protected $table = 'photos';

    public function create_photo(string $entity_type, int $entity_id, $file_path, string $name, int $type = 0)
    {
        return $this->create([
            'entity_type' => $entity_type,
            'entity_id'   => $entity_id,
            'path'        => $file_path,
            'alt'         => $name,
            'type'        => $type,

        ]);
    }

    public function read_photo($id = null)
    {
        if (is_null($id)) {
            return $this->all();
        }
        return $this->first(['entity_id' => $id]);
    }
    public function read_photo_by_id($entity_id, $entity_type, $first_photo_type_by_0 = FALSE)
    {
        if ($first_photo_type_by_0 === FALSE) {
            return   $this->connection->select("photos", "*",  [
                'entity_id'   => $entity_id,
                'entity_type' => $entity_type,
            ], ["ORDER" => "ASC"]);
        }
        return   $this->connection->select("photos", "*",  [
            'entity_id'   => $entity_id,
            'entity_type' => $entity_type,
            'type'        => 0,
        ], ["ORDER" => "ASC"]);
    }
    public function read_single_photo_by_id($type, $entity_id, $entity_type)
    {
        return   $this->connection->select("photos", "*",  [
            'type'        => $type,
            'entity_id'   => $entity_id,
            'entity_type' => $entity_type,
        ]);
    }

    public function update_photo(string $entity_type, int $entity_id, $file_path, string $name, int $type = 0)
    {
        return $this->update_create([
            'entity_type' => $entity_type,
            'entity_id'   => $entity_id,
            'path'        => $file_path,
            'alt'         => $name,
            'type'        => $type,

        ], ['entity_type' => $entity_type, 'entity_id' => $entity_id]);
    }

    public function delete_photo($id)
    {
        $categoryModel = $this->delete(['entity_id' => $id]);
        return $categoryModel;
    }
}
