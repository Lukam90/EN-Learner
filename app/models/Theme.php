<?php

namespace app\models;

use PDO;

use app\core\Security;

use app\models\Model;

class Theme extends Model {
    // Initialisation de l'objet PDO

    public function __construct() {
        $this->dbHandler = $this->init();
    }

    // Création de la table

    public function create() {
        $this->setQuery("CREATE TABLE IF NOT EXISTS themes (
                            id INTEGER PRIMARY KEY AUTO_INCREMENT,
                            title VARCHAR(50) UNIQUE NOT NULL,
                            user_id INTEGER NOT NULL,
                            FOREIGN KEY (user_id) REFERENCES users (id)
                            ON DELETE CASCADE
                        )");

        return $this->run();
    }

    // Suppression de la table

    public function drop() {
        $this->setQuery("DROP TABLE IF EXISTS themes");

        return $this->run();
    }

    // Sélection de l'ensemble des résultats

    public function findAll() {
        $this->setQuery("SELECT * FROM themes");

        return $this->fetchAll();
    }

    // Sélection d'une ligne par un ID

    public function findOneById($id) {
        $this->setQuery("SELECT *
                         FROM themes
                         WHERE id = :id");

        return $this->fetchOne("id", $id);
    }

    // Sélection d'un thème par le titre

    public function findOneByTitle($title) {
        $this->setQuery("SELECT *
                         FROM themes
                         WHERE title = :title");

        return $this->fetchOne("title", $title);
    }

    // Nombre d'éléments de la table

    public function count() {
        $this->setQuery("SELECT COUNT(id) FROM themes");

        return $this->withNone();
    }

    // Expressions d'un thème

    public function findExpressions($themeId) {
        $this->setQuery("SELECT e.*
                         FROM expressions e, themes t
                         WHERE e.theme_id = t.id
                         AND t.id = :id");

        return $this->fetchAllWith("id", $themeId);
    }

    // Nombre d'expressions d'un thème

    public function countExpressions($themeId) {
        $this->setQuery("SELECT COUNT(e.id)
                         FROM expressions e, themes t
                         WHERE e.theme_id = t.id
                         AND t.id = :id");

        return $this->withID($themeId);
    }

    // Nom de l'utilisateur

    public function findUser($themeId) {
        $this->setQuery("SELECT u.username
                         FROM users u, themes t
                         WHERE u.id = t.user_id
                         AND t.id = :id");

        return $this->fetchOne("id", $themeId);
    }

    // Appartenance à un utilisateur

    public function belongsTo($userId, $themeId) {
        $this->setQuery("SELECT COUNT(t.id)
                         FROM themes t, users u
                         WHERE t.user_id = u.id
                         AND u.id = :userId
                         AND t.id = :themeId");

        $data = [
            "userId" => $userId,
            "themeId" => $themeId
        ];

        return $this->withData($data);
    }

    // Ajout d'une nouvelle ligne

    public function insert($data) {
        $this->setQuery("INSERT INTO themes (title, user_id)
                         VALUES (:title, :user_id)");

        return $this->bindValues($data);
    }

    // Edition d'un thème

    public function update($id, $title) {
        $this->setQuery("UPDATE themes
                         SET title = :title
                         WHERE id = :id");

        $data = [
            "id" => $id,
            "title" => $title
        ];

        return $this->bindValues($data);
    }

    // Suppression d'une ligne par un ID

    public function delete($id) {
        $this->setQuery("DELETE FROM themes
                         WHERE id = :id");

        $data = ["id" => $id];

        return $this->bindValues($data);
    }
}