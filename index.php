<?php

require_once (__DIR__) . "/app/config/env.php";
require_once "vendor/autoload.php";

use Slim\App;
use Controllers;
use Tuupola\Middleware\JwtAuthentication;

$config = ['settings' => [
    'addContentLengthHeader' => false,
    'displayErrorDetails' => true,
]];

$app = new App($config);

$app->post('/register', [Controllers\UserController::class, "store"]);

$app->post('/login', [Controllers\SessionController::class, "login"]);

$app->post('/refresh-token', [Controllers\SessionController::class, "refreshToken"]);

$app->get('/listar-produtos', function ($req, $res, $args) {
    $products = [
        "products" => ["book", "table", "computer", "mouse"]
    ];

    return $res->withJson($products);
})->add(new JwtAuthentication(["secret" => getenv("JWT_SECRET")]));

$app->run();
