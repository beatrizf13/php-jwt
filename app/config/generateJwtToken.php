<?php
use \Firebase\JWT\JWT;

function generateToken() {  
    $key = "example_key";

    $tokenPayload = array(
        "iat" => time(), // timestamp_de_geracao
        "exp" => strtotime("+10 seconds"), // timestamp_de_expiracao
        "sub" => 0, // id_usuario
        "iss" => 0, // nome_emissor
        "aud" => 0, // nome_solicitante

    );

    return JWT::encode($tokenPayload, $key);
}

function generateRefreshToken() {
    $key = "example_key";

    $refreshTokenPayload = array(
        "sub" => 0, // id_usuario
        "iss" => 0, // nome_emissor
        "iat" => 0, // timestamp_de_geracao
    );

    return JWT::encode($refreshTokenPayload, $key);
}

