<?php

require __DIR__ . "/vendor/autoload.php";

use \App\Core\App;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

$app = new App();
$request = Request::createFromGlobals();
$response = $app->run($request);
$response->send();


