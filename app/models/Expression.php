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

    // Résultats liés à une table

    public function findAllBy($id, $fkName) {
        $tableName = $fkName . "s";
        $idName = $fkName . "_id";

        $statement = $this->dbHandler
                          ->prepare("
                                SELECT e.*
                                FROM expressions e, $tableName fk
                                WHERE e.$idName = fk.id
                                AND fk.id = :id
                            ");

        $statement->bindValue(":id", $id);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    // Expressions d'un thème

    public function findAllByTheme($themeId) {
        return $this->findAllBy($themeId, "theme");
    }

    // Expressions d'un auteur

    public function findAllByAuthor($userId) {
        return $this->findAllBy($userId, "user");
    }

    // Nombre d'expressions liées à une table

    public function countBy($id, $tableName) {
        $expressions = $this->findAllBy($id, $tableName);

        return count($expressions);
    }

    // Nombre d'expressions d'un thème

    public function countByTheme($themeId) {
        return $this->countBy($themeId, "theme");
    }

    // Nombre d'expressions d'un utilisateur

    public function countByUser($userId) {
        return $this->countBy($userId, "user");
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