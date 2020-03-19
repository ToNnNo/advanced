<?php

ini_set('display_errors', true);
error_reporting(E_ALL);
ini_set("soap.wsdl_cache_enabled", false);
ini_set("default_socket_timeout", 200);

require __DIR__ . "/vendor/autoload.php";

use \App\Core\App;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

$app = new App();
$request = Request::createFromGlobals();
$response = $app->run($request);
$response->send();