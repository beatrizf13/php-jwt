<?php

require_once "vendor/autoload.php";

use Slim\App;
use Controllers\SessionController;

$config = ['settings' => [
    'addContentLengthHeader' => false,
    'displayErrorDetails' => true,
]];

$app = new App($config);


$app->get('/login', [SessionController::class, "login"]);


$app->run();