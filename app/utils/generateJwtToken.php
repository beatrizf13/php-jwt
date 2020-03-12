<?php

use \Firebase\JWT\JWT;
use DAO\SessionDAO;

function generateToken($userId)
{
    $createdAt = time();
    $expiresAt = strtotime("+12 hours");

    $tokenPayload = [
        "iat" => $createdAt,
        "exp" => $expiresAt,
        "sub" => $userId,
        "iss" => getenv("NAME_APP")

    ];

    $refreshTokenPayload = [
        "sub" => $userId,
        "iss" => getenv("NAME_APP"),
        "iat" => $createdAt,
    ];

    $token = JWT::encode($tokenPayload, getenv("JWT_SECRET"));
    $refreshToken = JWT::encode($refreshTokenPayload, getenv("JWT_SECRET"));

    $session = (new SessionDAO)->insert($userId, $token, $refreshToken, $createdAt, $expiresAt);

    if ($session != null) {

        return [
            "token" => $token,
            "refreshToken" => $refreshToken,
            "createdAt" => date('Y-m-d H:i:s', $createdAt),
            "expiresAt" => date('Y-m-d H:i:s', $expiresAt),
        ];
    }

    return null;
}
