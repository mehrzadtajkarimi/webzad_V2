<?php
if ($_SERVER['REQUEST_URI']!="/" && substr($_SERVER['REQUEST_URI'],-1,1)=="/")
{
	header("location: ".substr($_SERVER['REQUEST_URI'],0,strlen($_SERVER['REQUEST_URI'])-1));
	exit;
	die();
}

use App\Core\Routing\Router;

include "../App/Bootstrap.php";

$router = new Router;
$router->run();


