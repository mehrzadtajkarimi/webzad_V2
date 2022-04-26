<?php

use App\Core\Request;
use App\database\seeders\DatabaseSeeder;

session_start();
ini_set('display_errors', '1');
error_reporting(E_ALL);
date_default_timezone_set("Asia/Tehran");
define('BASEPATH', rtrim($_SERVER['DOCUMENT_ROOT'], 'Public'));
// define('BASEPATH', '/home/cp47323/public_html/');

include BASEPATH . "vendor/autoload.php";
include BASEPATH . "App/Services/jdf.php";

$dotenv = Dotenv\Dotenv::createImmutable(BASEPATH);
$dotenv->load();
$request = new Request;

// $database_seeder = new DatabaseSeeder;
// $database_seeder->run();


include BASEPATH . "App/Helpers/helper.php";
include BASEPATH . "App/Routes/Backend.php";
include BASEPATH . "App/Routes/Frontend.php";
