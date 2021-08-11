<?php

namespace app\models;

use app\models\Model;

use app\core\Security;

class Expression extends Model {
    // Initialisation de l'objet PDO

    public function __construct() {
        $this->dbHandler = $this->init();
        $this->tableName = "expressions";
        $this->definition = "
            id INTEGER PRIMARY KEY AUTO_INCREMENT,
            french VARCHAR(255) UNIQUE NOT NULL,
            english VARCHAR(255) UNIQUE NOT NULL,
            phonetics VARCHAR(255) UNIQUE NOT NULL,
            user_id INTEGER NOT NULL,
            theme_id INTEGER NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users (id),
            FOREIGN KEY (theme_id) REFERENCES themes (id)
            ON DELETE CASCADE
        ";
    }

    // Nombre d'expressions liées à une table

    public function countBy($id, $tableName) {
        $expressions = $this->findAllBy($id, $tableName);

        return count($expressions);
    }

    // Appartenance à un utilisateur

    public function belongsTo($userId, $expressionId) {
        $statement = $this->dbHandler
                          ->prepare("
                                SELECT e.id
                                FROM expressions e, users u
                                WHERE e.user_id = u.id
                                AND u.id = :userId
                                AND e.id = :expressionId
                            ");

        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":expressionId", $expressionId);

        $statement->execute();

        return $statement->fetchColumn() != 0;
    }
}