<?php

namespace app\models;

use PDO;

use app\core\Security;

use app\models\Model;

class Expression extends Model {
    // Initialisation de l'objet PDO

    public function __construct() {
        $this->dbHandler = $this->init();
    }

    // Création de la table

    public function create() {
        return $this->run("CREATE TABLE IF NOT EXISTS expressions (
                            id INTEGER PRIMARY KEY AUTO_INCREMENT,
                            french VARCHAR(255) UNIQUE NOT NULL,
                            english VARCHAR(255) UNIQUE NOT NULL,
                            phonetics VARCHAR(255) UNIQUE NOT NULL,
                            user_id INTEGER NOT NULL,
                            theme_id INTEGER NOT NULL,
                            FOREIGN KEY (user_id) REFERENCES users (id),
                            FOREIGN KEY (theme_id) REFERENCES themes (id)
                            ON DELETE CASCADE
                        )");
    }

    // Suppression de la table

    public function drop() {
        return $this->dropTable("expressions");
    }

    // Sélection de l'ensemble des résultats

    public function findAll() {
        return $this->selectAll("expressions");
    }

    // Sélection d'une ligne par un ID

    public function findById($id) {
        $query = "SELECT *
                  FROM expressions
                  WHERE id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    // Nombre d'éléments de la table

    public function count() {
        return $this->countLines("expressions");
    }

    // Appartenance à un utilisateur

    public function belongsToUser($userId, $expressionId) {
        $query = "SELECT e.id
                  FROM expressions e, users u
                  WHERE e.user_id = u.id
                  AND u.id = :userId
                  AND e.id = :expressionId";

        $statement = $this->prepare($query);

        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":expressionId", $expressionId);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    // Ajout d'une nouvelle ligne

    public function insert($values) {
        $query = "INSERT INTO expressions (french, english, phonetics, theme_id, user_id)
                  VALUES (:french, :english, :phonetics, :themeId, :userId)";

        $statement = $this->prepare($query);

        $statement->bindValue(":french", $values["french"]);
        $statement->bindValue(":english", $values["english"]);
        $statement->bindValue(":phonetics", $values["phonetics"]);
        $statement->bindValue(":themeId", $values["theme_id"]);
        $statement->bindValue(":userId", $values["user_id"]);

        return $statement->execute();
    }

    // Edition d'une expression

    public function update($id, $values) {
        $query = "UPDATE expressions
                  SET french = :french
                      english = :english
                      phonetics = :phonetics
                  WHERE id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);

        $statement->bindValue(":french", $values["french"]);
        $statement->bindValue(":english", $values["english"]);
        $statement->bindValue(":phonetics", $values["phonetics"]);

        return $statement->execute();
    }

    // Suppression d'une ligne par un ID

    public function delete($id) {
        return $this->deleteLine("expressions", $id);
    }
}