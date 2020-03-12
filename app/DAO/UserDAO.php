<?php

namespace DAO;

class UserDAO extends DAO
{
    public function show($username)
    {
        try {
            $sql = "SELECT user.id, user.username FROM user WHERE user.username = :username";
            $req = $this->PDO->prepare($sql);
            $req->bindValue(":username", $username);

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

    public function insert($username, $password)
    {
        $result = $this->show($username);

        if (!empty($result)) {
            return $result;
        }

        try {
            $sql = "INSERT INTO user(username, password) VALUES (:username, :password)";
            $req = $this->PDO->prepare($sql);
            $req->bindValue(":username", $username);
            $req->bindValue(":password", $password);

            if ($req->execute()) {
                $result = $this->show($username);

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
