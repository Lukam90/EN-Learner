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
        $this->setQuery("CREATE TABLE IF NOT EXISTS expressions (
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

        return $this->run();
    }

    // Suppression de la table

    public function drop() {
        $this->setQuery("DROP TABLE IF EXISTS expressions");

        return $this->run();
    }

    // Sélection de l'ensemble des résultats

    public function findAll() {
        $this->setQuery("SELECT * FROM expressions");

        return $this->fetchAll();
    }

    // Sélection d'une ligne par un ID

    public function findOneById($id) {
        $this->setQuery("SELECT *
                         FROM expressions
                         WHERE id = :id");

        return $this->fetchOne("id", $id);
    }

    // Nombre d'éléments de la table

    public function count() {
        $this->setQuery("SELECT COUNT(id) FROM expressions");

        return $this->withNone();
    }

    // Appartenance à un utilisateur

    public function belongsTo($userId, $expressionId) {
        $this->setQuery("SELECT e.id
                         FROM expressions e, users u
                         WHERE e.user_id = u.id
                         AND u.id = :userId
                         AND e.id = :expressionId");

        $data = [
            "userId" => $userId,
            "expressionId" => $expressionId
        ];

        return (bool) $this->withData($data);
    }

    // Ajout d'une nouvelle ligne

    public function insert($data) {
        $this->setQuery("INSERT INTO expressions (french, english, phonetics, theme_id, user_id)
                         VALUES (:french, :english, :phonetics, :theme_id, :user_id)");

        return $this->bindValues($data);
    }

    // Edition d'une expression

    public function update($id, $data) {
        $this->setQuery("UPDATE expressions
                         SET french = :french,
                             english = :english,
                             phonetics = :phonetics
                         WHERE id = :id");

        $data["id"] = $id;

        return $this->bindValues($data);
    }

    // Suppression d'une ligne par un ID

    public function delete($id) {
        $this->setQuery("DELETE FROM expressions
                         WHERE id = :id");

        $data = ["id" => $id];

        return $this->bindValues($data);
    }
}