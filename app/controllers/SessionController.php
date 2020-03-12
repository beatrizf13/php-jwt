<?php

namespace Controllers;

use DAO;

require_once getenv("PATH_APP") . "/utils/generateJwtToken.php";

class SessionController
{
    public static function login($req, $res, $args)
    {
        $body = $req->getParsedBody();

        if (!isset($body["username"]) || !isset($body["password"])) {
            return $res->withStatus(401)->withJson(["message" => "username and password are required"]);
        }

        $user = (new DAO\UserDAO)->show($body["username"]);

        if (!isset($user)) {
            return $res->withStatus(401)->withJson(["message" => "user does not exist"]);
        }

        $user = (new DAO\AuthDAO)->login($body["username"]);

        if (!isset($user)) {
            return $res->withStatus(500)->withJson(["message" => "something went wrong"]);
        }

        if (password_verify($body["password"], $user["password"])) {
            $session = (new DAO\SessionDAO)->show($user["id"]);

            if (!isset($session)) {
                $session = generateToken($user["id"]);
            }

            if (!isset($session)) {
                return $res->withStatus(500)->withJson(["message" => "something went wrong"]);
            }

            return $res->withJson([
                "token" => $session["token"],
                "refreshToken" =>  $session["refreshToken"],
                "createdAt" =>  $session["createdAt"],
                "expiresAt" =>  $session["expiresAt"],
            ]);
        } else {
            return $res->withStatus(401)->withJson(["message" => "invalid credentials"]);
        }
    }

    public static function refreshToken($req, $res, $args)
    {
        $body = $req->getParsedBody();

        if (!isset($body["refreshToken"])) {
            return $res->withStatus(401)->withJson(["message" => "refreshToken is required"]);
        }

        $session = (new DAO\SessionDAO)->refreshToken($body["refreshToken"]);

        if (!isset($session)) {
            return $res->withStatus(401)->withJson(["message" => "invalid refresh token"]);
        }

        $session = (new DAO\SessionDAO)->show($session["userId"]);

        if (!isset($session)) {
            $session = generateToken($session["userId"]);
        }

        if (!isset($session)) {
            return $res->withStatus(500)->withJson(["message" => "something went wrong"]);
        }

        return $res->withJson([
            "token" => $session["token"],
            "refreshToken" =>  $session["refreshToken"],
            "createdAt" =>  $session["createdAt"],
            "expiresAt" =>  $session["expiresAt"],
        ]);
    }
}
