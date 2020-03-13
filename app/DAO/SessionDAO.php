<?php

namespace DAO;

class SessionDAO extends DAO
{
    public function show($userId)
    {
        try {
            $sql = "SELECT token, refreshToken, createdAt, expiresAt FROM token WHERE userId = :userId AND expiresAt >= NOW()";
            $req = $this->PDO->prepare($sql);
            $req->bindValue(":userId", $userId);


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

    public function insert($userId, $token, $refreshToken, $createdAt, $expiresAt)
    {
        try {
            $sql = "INSERT INTO token(userId, token, refreshToken, createdAt, expiresAt) VALUES (:userId, :token, :refreshToken, :createdAt, :expiresAt)";
            $req = $this->PDO->prepare($sql);

            $req->bindValue(":userId", $userId);
            $req->bindValue(":token", $token);
            $req->bindValue(":refreshToken", $refreshToken);
            $req->bindValue(":createdAt", date('Y-m-d H:i:s', $createdAt));
            $req->bindValue(":expiresAt", date('Y-m-d H:i:s', $expiresAt));

            if ($req->execute()) {

                $this->deleteExpired($userId);

                return [
                    "ok" => true
                ];
            }
        } catch (\Exception $error) {
            echo $error->getMessage();
        }

        return null;
    }

    public function deleteExpired($userId)
    {
        try {
            $sql = "DELETE FROM token WHERE userId = :userId AND expiresAt < NOW()";
            $req = $this->PDO->prepare($sql);
            $req->bindValue(":userId", $userId);

            if ($req->execute()) {
                return [
                    "ok" => true
                ];
            }
        } catch (\Exception $error) {
            echo $error->getMessage();
        }

        return null;
    }
}
