<?php

require __DIR__ . "/vendor/autoload.php";

use \App\Core\App;
use \App\Core\Request;

$app = new App();
$request = Request::createRequestFromGlobal();
$response = $app->run($request);

echo $response;