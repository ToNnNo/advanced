<?php

return [
    ['name' => "home_index", "route" => "/", "controller" => \App\Controller\HomeController::class, "action" => "index"],
    ['name' => "design_pattern_index", "route" => "/design-pattern", "controller" => \App\Controller\DesignPattern::class, "action" => "index"],
    ['name' => "design_pattern_singleton", "route" => "/design-pattern/singleton", "controller" => \App\Controller\DesignPattern::class, "action" => "singleton"],
    ['name' => "design_pattern_collection", "route" => "/design-pattern/collection", "controller" => \App\Controller\DesignPattern::class, "action" => "collection"],
    ['name' => "design_pattern_table", "route" => "/design-pattern/builder/table", "controller" => \App\Controller\DesignPattern::class, "action" => "table"],
    ['name' => "design_pattern_query", "route" => "/design-pattern/builder/query", "controller" => \App\Controller\DesignPattern::class, "action" => "query"],
    ['name' => "crypto_index", "route" => "/hash", "controller" => \App\Controller\CryptoController::class, "action" => "index"],
    ['name' => "openssl_generate", "route" => "/generate", "controller" => \App\Controller\CryptoController::class, "action" => "generate"],
    ['name' => "openssl_crypt", "route" => "/openssl/crypt", "controller" => \App\Controller\CryptoController::class, "action" => "crypt"],
    ['name' => "openssl_decrypt", "route" => "/openssl/decrypt", "controller" => \App\Controller\CryptoController::class, "action" => "decrypt"],
    ['name' => "orm_course", "route" => "/orm/course", "controller" => \App\Controller\ORMController::class, "action" => "course"],
    ['name' => "orm_index", "route" => "/orm", "controller" => \App\Controller\ORMController::class, "action" => "index"],
    ['name' => "orm_add", "route" => "/orm/add", "controller" => \App\Controller\ORMController::class, "action" => "add"],
    ['name' => "orm_edit", "route" => "/orm/edit/{id}", "controller" => \App\Controller\ORMController::class, "action" => "edit"],
    ['name' => "orm_remove", "route" => "/orm/remove/{id}", "controller" => \App\Controller\ORMController::class, "action" => "remove"],

    ['name' => "soap_server_index", "route" => "/soap", "controller" => \App\Controller\SoapServerController::class, "action" => "index"],
    ['name' => "soap_server_product", "route" => "/soap/server", "controller" => \App\Controller\SoapServerController::class, "action" => "product"],
    ['name' => "soap_client_index", "route" => "/soap/client", "controller" => \App\Controller\SoapClientController::class, "action" => "index"],

    ['name' => "api_rest_course", "route" => "/api/course", "controller" => \App\Controller\RestController::class, "action" => "course"],
    ['name' => "api_rest_index", "route" => "/api/products", "controller" => \App\Controller\RestController::class, "action" => "index"],
    ['name' => "api_rest_show", "route" => "/api/products/{id}", "controller" => \App\Controller\RestController::class, "action" => "show"]
];