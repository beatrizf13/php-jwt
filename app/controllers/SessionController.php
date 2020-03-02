<?php

namespace Controllers;

require_once dirname(__DIR__, 1) . "/config/generateJwtToken.php";

class SessionController
{
    public static function login($req, $res, $args)
    {
        $body = $req->getParsedBody();

        if(!($body["username"] == "beatriz") || !($body["password"] == "123456")) {
            return $res->withStatus(400)->withJson([ "message" => "invalid credentials"]);
        }

        return $res->withJson([
            "token" =>  generateToken(),
            "refresh_token" =>  generateRefreshToken()
        ]);
  
        return $res;
    }
}