<?php

namespace app\models;

use app\models\Model;

use app\core\Security;

class Expression extends Model {
    // Initialisation de l'objet PDO

    public function __construct() {
        $this->dbHandler = $this->init();
    }

    // Création de la table

    public function create() {
        return $this->raw("CREATE TABLE IF NOT EXISTS expressions (
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
        return $this->raw("DROP TABLE IF EXISTS expressions");
    }

    // Sélection de l'ensemble des résultats

    public function findAll() {
        return $this->fetchAll("SELECT * FROM expressions");
    }

    // Sélection d'une ligne par un attribut

    public function findBy($attribute, $value) {
        return parent::findBy("expressions", $attribute, $value);
    }

    // Sélection d'une ligne par un ID

    public function findById($id) {
        return $this->findBy("id", $id);
    }

    // Nombre d'éléments de la table

    public function count() {
        return $this->fetchColumn("SELECT COUNT(id) FROM expressions");
    }

    // Ajout d'une nouvelle ligne

    public function insert($data) {
        return parent::insert("expressions", $data);
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