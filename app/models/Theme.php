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
        return $this->run("CREATE TABLE IF NOT EXISTS themes (
                            id INTEGER PRIMARY KEY AUTO_INCREMENT,
                            title VARCHAR(50) UNIQUE NOT NULL,
                            user_id INTEGER NOT NULL,
                            FOREIGN KEY (user_id) REFERENCES users (id)
                            ON DELETE CASCADE
                         )");
    }

    // Suppression de la table

    public function drop() {
        return $this->dropTable("themes");
    }

    // Sélection de l'ensemble des résultats

    public function findAll() {
        return $this->selectAll("themes");
    }

    // Sélection d'une ligne par un ID

    public function findById($id) {
        $query = "SELECT *
                  FROM themes
                  WHERE id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    // Sélection d'un thème par le titre

    public function findByTitle($title) {
        $query = "SELECT *
                  FROM themes
                  WHERE title = :title";

        $statement = $this->prepare($query);

        $statement->bindValue(":title", $title);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    // Nombre d'éléments de la table

    public function count() {
        return $this->countLines("themes");
    }

    // Expressions d'un thème

    public function findExpressions($themeId) {
        $query = "SELECT e.*
                  FROM expressions e, themes t
                  WHERE e.theme_id = t.id
                  AND t.id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $themeId);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    // Nombre d'expressions d'un thème

    public function countExpressions($themeId) {
        $expressions = $this->findExpressions($themeId);

        return count($expressions);
    }

    // Nom de l'utilisateur

    public function findUser($themeId) {
        $query = "SELECT u.username
                  FROM users u, themes t
                  WHERE u.id = t.user_id
                  AND t.id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $themeId);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_OBJ);
    }

    // Appartenance à un utilisateur

    public function belongsToUser($userId, $themeId) {
        $query = "SELECT t.id
                  FROM themes t, users u
                  WHERE t.user_id = u.id
                  AND u.id = :userId
                  AND t.id = :themeId";

        $statement = $this->prepare($query);

        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":themeId", $themeId);

        return $statement->execute();
    }

    // Ajout d'une nouvelle ligne

    public function insert($data) {
        $query = "INSERT INTO themes (title, user_id)
                  VALUES (:title, :userId)";

        $statement = $this->prepare($query);

        $statement->bindValue(":title", $data["title"]);
        $statement->bindValue(":userId", $data["user_id"]);

        return $statement->execute();
    }

    // Edition d'un thème

    public function update($id, $title) {
        $query = "UPDATE themes
                  SET title = :title
                  WHERE id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $data["id"]);
        $statement->bindValue(":title", $data["title"]);

        return $statement->execute();
    }

    // Suppression d'une ligne par un ID

    public function delete($id) {
        return $this->deleteLine("themes", $id);
    }
}