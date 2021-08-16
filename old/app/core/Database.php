<?php

namespace app\core;

class Database {
    private $dbHandler;
    private $error;

    // PDO Initialization

    public function __construct() {
        try {
            $this->dbHandler = new \PDO("mysql:host=127.0.0.1;dbname=en_learner", "root", "");
            $this->dbHandler->setAttribute(\PDO::ATTR_PERSISTENT, true);
            $this->dbHandler->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();

            echo $this->error;
        }
    }

    // Get database handler (PDO)

    public function getHandler() {
        return $this->dbHandler;
    }
}