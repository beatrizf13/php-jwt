<?php

namespace DAO;

abstract class DAO
{
  protected $PDO;

  public function __construct()
  {
    $connection = Connection::getInstance(getenv("DB_HOST"), getenv("DB_NAME"), getenv("DB_USERNAME"), getenv("DB_PASSWORD"));
    $connection = $connection->getConnection();

    $this->PDO = $connection;
  }
}
