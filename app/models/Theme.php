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

    // Sélection d'un thème par l'ID

    public function findById($id) {
        return $this->findBy("id", $id);
    }

    // Sélection d'un thème par le titre

    public function findByTitle($title) {
        return $this->findBy("title", $title);
    }

    // Sélection de thèmes d'un utilisateur

    public function findAllByUser($id) {
        $statement = $this->dbHandler
                          ->prepare("
                                SELECT t.*
                                FROM themes t, users u
                                WHERE t.user_id = u.id
                                AND u.id = :id
                            ");

        $statement->bindValue(":id", $id);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    // Nombre de thèmes d'un utilisateur

    public function countByUser($id) {
        $themes = $this->findAllByUser($id);

        return count($themes);
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