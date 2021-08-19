<?php

namespace app\models;

use app\core\Database;
use app\core\Security;

abstract class Model {
    protected $dbHandler;
    protected $tableName;

    /* Fonctions générales */

    // Initialisation de l'objet PDO
    // Connexion à la BDD

    public function init() {
        $db = new Database();
        
        return $db->getHandler();
    }

    // Requête générale brute (ex : création)

    public function run($query) {
        return $this->dbHandler
                    ->exec();
    }

    // Requête préparée

    public function prepare($query) {
        return $this->dbHandler
                    ->prepare($query);
    }

    // Requête générale

    public function query($sql) {
        return $this->dbHandler
                    ->query($sql);
    }

    /* Fonctions CRUD */

    // Suppression de la table

    public function dropTable($tableName) {
        return $this->run("DROP TABLE IF EXISTS $tableName");
    }

    // Sélection de l'ensemble des résultats

    public function selectAll($tableName) {
        return $this->query("SELECT * FROM $tableName")
                    ->fetchAll(\PDO::FETCH_OBJ);
    }

    // Requête préparée avec un attribut

    public function withAttribute($attribute, $value) {
        $statement = $this->prepare();

        $statement->bindValue(":$attribute", $value);

        return $statement->execute();
    }

    // Requête préparée avec un ID

    public function withID($id) {
        return $this->withAttribute("id", $id);
    }

    // Requête préparée avec données

    public function withData($data) {
        $statement = $this->prepare();

        foreach ($data as $key => $value) {
            if ($key == "password") {
                $value = Security::hash($value);
            }

            $statement->bindValue(":$key", $value);
        }

        return $statement->execute();
    }

    

    // Sélection d'une colonne (ex : nombre)

    public function countLines($tableName) {
        return $this->query("SELECT COUNT(id) FROM $tableName")
                    ->fetchColumn();
    }

    // Sélection d'une ligne par un attribut

    public function fetchBy($attribute, $value) {
        $statement = $this->prepare();

        $statement->bindParam(":$attribute", $value);
        
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    // Sélection d'une ligne par un ID

    public function fetchByID($id) {
        return $this->fetchBy("id", $id);
    }

    // Sélection de l'ensemble des lignes par un attribut

    public function fetchAllBy($attribute, $value) {
        $statement = $this->prepare();

        $statement->bindParam(":$attribute", $value);
        
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    // Sélection de l'ensemble des lignes par un ID

    public function fetchAllByID($id) {
        return $this->fetchAllBy("id", $id);
    }

    // Vérification d'une ligne par un attribut avec ID

    public function is($id) {
        $statement = $this->prepare();

        $statement->bindValue(":id", $id);

        $statement->execute();

        return $statement->fetchColumn() > 0;
    }

    // Appartenance

    public function belongsTo($data) {
        $statement = $this->prepare();

        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();

        return $statement->fetchColumn() > 0;
    }

    // Suppression d'une ligne par un ID

    public function deleteLine($tableName, $id) {
        $query = "DELETE FROM $tableName
                  WHERE id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);

        return $statement->execute();
    }
}