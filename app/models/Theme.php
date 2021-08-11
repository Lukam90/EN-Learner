<?php

namespace app\models;

use app\models\Model;

use app\core\Security;

class Theme extends Model {
    // Initialisation de l'objet PDO

    public function __construct() {
        $this->dbHandler = $this->init();
        $this->tableName = "themes";
        $this->definition = "
            id INTEGER PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) UNIQUE NOT NULL,
            user_id INTEGER NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users (id)
            ON DELETE CASCADE
        ";
    }

    // Sélection d'un thème par le titre

    public function findByTitle($title) {
        return $this->findBy("title", $title);
    }

    // Expressions d'un thème

    public function findExpressions($themeId) {
        $statement = $this->dbHandler
                          ->prepare("
                                SELECT e.*
                                FROM expressions e, themes t
                                WHERE e.theme_id = t.id
                                AND t.id = :id
                            ");

        $statement->bindValue(":id", $themeId);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    // Nombre d'expressions d'un thème

    public function countExpressions($themeId) {
        $expressions = $this->findExpressions($themeId);

        return count($expressions);
    }

    // Nom de l'utilisateur

    public function findUser($themeId) {
        $statement = $this->dbHandler
                          ->prepare("
                                SELECT u.username
                                FROM users u, themes t
                                WHERE u.id = t.user_id
                                AND t.id = :id
                            ");

        $statement->bindValue(":id", $themeId);

        $statement->execute();

        return $statement->fetchColumn();
    }

    // Appartenance à un utilisateur

    public function belongsTo($userId, $themeId) {
        $statement = $this->dbHandler
                          ->prepare("
                                SELECT t.id
                                FROM themes t, users u
                                WHERE t.user_id = u.id
                                AND u.id = :userId
                                AND t.id = :themeId
                            ");

        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":themeId", $themeId);
        
        $statement->execute();

        return $statement->fetchColumn() != 0;
    }
}