<?php

namespace Libs\Database;

use PDO;
use PDOException;

class MySql
{
    public function __construct(
        private string $dbhost = "localhost",
        private string $dbname = "project",
        private string $dbuser = "root",
        private string $dbpass = "root",
        private ?PDO $db = null
    )
    {
    }

    public function connect(): PDO|string
    {
        try {
            return new PDO(
                "mysql:dbhost=$this->dbhost;dbname=$this->dbname",
                $this->dbuser, $this->dbpass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]);
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
}
