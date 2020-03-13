<?php

namespace DAO;

class AuthDAO extends DAO
{

    public function login($username)
    {
        try {
            $sql = "SELECT user.id, user.username, user.password FROM user WHERE user.username = :username";
            $req = $this->PDO->prepare($sql);
            $req->bindValue(":username", $username);
            $req->execute();
            $result = $req->fetch();

            if (!empty($result)) {
                return $result;
            }
        } catch (\Exception $error) {
            echo $error->getMessage();
        }

        return null;
    }

    public function refreshToken($refreshToken)
    {
        try {
            $sql = "SELECT userId FROM token WHERE refreshToken = :refreshToken";
            $req = $this->PDO->prepare($sql);
            $req->bindValue(":refreshToken", $refreshToken);


            if ($req->execute()) {
                $result = $req->fetch();

                if (!empty($result)) {
                    return $result;
                }
            }
        } catch (\Exception $error) {
            echo $error->getMessage();
        }

        return null;
    }
}
