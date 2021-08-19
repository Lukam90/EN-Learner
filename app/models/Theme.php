<?php

namespace app\models;

use app\models\Model;

use app\core\Security;

class Theme extends Model {
    // Initialisation de l'objet PDO

    public function __construct() {
        $this->dbHandler = $this->init();
    }

    // Création de la table

    public function create() {
        return $this->raw("CREATE TABLE IF NOT EXISTS themes (
                           id INTEGER PRIMARY KEY AUTO_INCREMENT,
                           title VARCHAR(50) UNIQUE NOT NULL,
                           user_id INTEGER NOT NULL,
                           FOREIGN KEY (user_id) REFERENCES users (id)
                           ON DELETE CASCADE
                        )");
    }

    // Suppression de la table

    public function drop() {
        return $this->raw("DROP TABLE IF EXISTS themes");
    }

    // Sélection de l'ensemble des résultats

    public function findAll() {
        return $this->fetchAll("SELECT * FROM themes");
    }

    // Sélection d'une ligne par un attribut

    public function findBy($attribute, $value) {
        return parent::findBy("themes", $attribute, $value);
    }

    // Sélection d'une ligne par un ID

    public function findById($id) {
        return $this->findBy("id", $id);
    }

    // Sélection d'un thème par le titre

    public function findByTitle($title) {
        return $this->findBy("title", $title);
    }

    // Nombre d'éléments de la table

    public function count() {
        return $this->fetchColumn("SELECT COUNT(id) FROM themes");
    }

    // Ajout d'une nouvelle ligne

    public function insert($data) {
        return parent::insert("themes", $data);
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