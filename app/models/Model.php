<?php

namespace app\models;

use app\core\Database;
use app\core\Security;

abstract class Model {
    protected $dbHandler;
    protected $query;

    // Initialisation de l'objet PDO
    // Connexion à la BDD

    public function init() {
        $db = new Database();
        
        return $db->getHandler();
    }

    // Edition d'une requête

    public function setQuery($value) {
        $this->query = $value;
    }

    // Récupération d'une requête

    public function getQuery() {
        return $this->query;
    }

    // Requête générale brute (ex : création)

    public function run() {
        return $this->dbHandler
                    ->exec($this->getQuery());
    }

    // Requête préparée

    public function prepare() {
        return $this->dbHandler
                    ->prepare($this->getQuery());
    }

    // Requête générale

    public function query() {
        return $this->dbHandler
                    ->query($this->getQuery());
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

    // Sélection de l'ensemble des résultats

    public function fetchAll() {
        return $this->query()
                    ->fetchAll(\PDO::FETCH_OBJ);
    }

    // Sélection d'une colonne (ex : nombre)

    public function fetchColumn() {
        return $this->query()
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
        $statement = $this->withData($data);

        return $statement->fetchColumn() > 0;
    }
}