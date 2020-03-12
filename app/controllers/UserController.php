<?php

namespace Controllers;

use DAO\UserDAO;

class UserController
{
    public static function store($req, $res, $args)
    {
        $body = $req->getParsedBody();

        if (!isset($body["username"]) || !isset($body["password"])) {
            return $res->withStatus(401)->withJson(["message" => "username and password are required"]);
        }

        $user = (new UserDAO)->insert($body["username"], password_hash($body["password"], PASSWORD_ARGON2I));

        if (!isset($user)) {
            return $res->withStatus(500)->withJson(["message" => "something went wrong"]);
        }

        return $res->withJson([
            "user" => [
                "id" => $user["id"],
                "username" => $user["username"]
            ]
        ]);
    }
}
