<?php

namespace App\Utilities;

use App\Models\Photo as ModelsPhoto;

class Photo
{
    private $photo;

    public function __construct()
    {
        $this->photo = new ModelsPhoto();
    }

    public static function add($entity_type, $entity_id)
    {
        $photo_id =  self::$photo->create([
            'entity_type' => $entity_type,
            'entity_id' => $entity_id
        ]);
        if ($photo_id) {
            FlashMessage::add('ثبت  با موفقیت انجام شد', FlashMessage::SUCCESS);
        } else {
            FlashMessage::add('مشکلی در هنگام ثبت  رخ داده است', FlashMessage::WARNING);
        }
        return $photo_id ;
    }
    public static function get($entity_type, $entity_id)
    {
        $photo =  self::$photo->get('*',[
            'entity_type' => $entity_type,
            'entity_id' => $entity_id
        ]);
        if ($photo) {
            FlashMessage::add('ثبت  با موفقیت انجام شد', FlashMessage::SUCCESS);
        } else {
            FlashMessage::add('مشکلی در هنگام ثبت  رخ داده است', FlashMessage::WARNING);
        }
        return $photo;
    }
}
