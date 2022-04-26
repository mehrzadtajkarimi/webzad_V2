<?php

namespace App\Services\Upload;

use App\Services\Upload\Contract\UploadContract;
use App\Utilities\FlashMessage;

class UploadedFile implements UploadContract
{
    private $files;
    private $array_keys_name;
    private $array_keys_tmp_name;
    private $array_files_is_param_get_first;
    private $array_files_is_param_get_tmp_name;
    private $array_filter_trim_end_null;
    private $array_count;
    private $paths_in_storage;
    private $paths_for_storage;
    private $paths_for_database;
    const default_subfolder_format = "Ym";

    public function __construct($files_param)
    {
        $this->files                             = $files_param;
        $this->array_keys_name                   = $this->files[array_keys($this->files)[0]];
        $this->array_keys_tmp_name               = $this->files[array_keys($this->files)[2]];
        $this->array_files_is_param_get_first    = is_array($this->array_keys_name) ? $this->array_keys_name : [$this->array_keys_name];
        $this->array_files_is_param_get_tmp_name = is_array($this->array_keys_tmp_name) ? $this->array_keys_tmp_name : [$this->array_keys_tmp_name];
        $this->array_filter_trim_end_null        = array_filter($this->array_files_is_param_get_first);
        $this->array_count                       = count($this->array_filter_trim_end_null);
        for ($i = 0; $i < $this->array_count; $i++) {
            $this->paths_in_storage     = $this->generate_paths($i);
            $this->paths_for_database[] = base_url() . "Storage/$this->paths_in_storage";
            $this->paths_for_storage[]  = BASEPATH . "Public/Storage/$this->paths_in_storage";
        }
    }

    public function  generate_paths($key)
    {
        $name             = substr($this->array_filter_trim_end_null[$key], 0, 64);
        $name_explode     = explode('.', $name);
        $type_file        = end($name_explode);
        $basename         = basename($name, $type_file);
        $basename_trim    = trim($basename);
        $sub_folder_date  = date(self::default_subfolder_format);
        $paths_in_storage = BASEPATH . 'Public/Storage/' . $sub_folder_date;
        !file_exists($paths_in_storage) ? mkdir($paths_in_storage) : '';

        return $sub_folder_date . '/' . $basename_trim . '---' . $this->generate_random_str() . '.' . $type_file;
    }

    private function generate_random_str()
    {
        return bin2hex(random_bytes(4));
    }

    public function destroy()
    {
        if (!file_exists($this->paths_for_storage)) {
            return;
        }
        return unlink($this->paths_for_storage);
    }

    private function upload()
    {
        foreach ($this->array_files_is_param_get_tmp_name as $key => $path) {
            move_uploaded_file($path, $this->paths_for_storage[$key]);
        }
        return true;
    }



    public function save()
    {
        return $this->upload() ? $this->paths_for_database : false;
    }
    public function get_paths_for_storage()
    {
        return $this->paths_for_storage;
    }
    public function get_paths_for_database()
    {
        return $this->paths_for_database;
    }
}
