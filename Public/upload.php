<?php




if (isset($_FILES['upload']['name'])) {

    $files               = $_FILES['upload'];
    $array_keys_name     = $files[array_keys($files)[0]];
    $array_keys_tmp_name = $files[array_keys($files)[2]];


    // die($array_keys_tmp_name);
    $name                = substr($array_keys_name, 0, 64);
    $name_explode        = explode('.', $name);
    $type_file           = end($name_explode);
    $basename            = basename($name, $type_file);
    $basename_trim       = trim($basename);
    $sub_folder_date     = date("Ym");
    $paths_in_storage    = $_SERVER["DOCUMENT_ROOT"] . '/Storage/' . $sub_folder_date;
    !file_exists($paths_in_storage) ? mkdir($paths_in_storage) : '';
    $generate_paths     = $sub_folder_date . '/' . $basename_trim . '---' . bin2hex(random_bytes(4)) . '.' . $type_file;
    $paths_for_database = $_ENV['BASE_URL'] . "Storage/$generate_paths";
    $paths_for_storage  = $_SERVER["DOCUMENT_ROOT"] . "/Storage/$generate_paths";

    move_uploaded_file($_FILES['upload']['tmp_name'], $paths_for_storage);

    $function_number = $_GET['CKEditorFuncNum'];
    $url = $paths_for_database;
    $message = '';
    echo "<script>window.parent.CKEDITOR.tools.callFunction('" . $function_number . "','" . $url . "','" . $message . "');</script>";
}
