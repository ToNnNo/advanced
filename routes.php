<?php

return [
    ['name' => "home_index", "route" => "/", "controller" => \App\Controller\HomeController::class, "action" => "index"],
    ['name' => "crypto_index", "route" => "/hash", "controller" => \App\Controller\CryptoController::class, "action" => "index"]
];