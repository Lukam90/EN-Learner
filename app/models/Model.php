<?php

namespace app\models;

use PDO;

use app\core\Database;
use app\core\Security;

abstract class Model {
    protected $dbHandler;
    protected $query;

    /* Fonctions générales (PDO) */

    // Initialisation de l'objet PDO
    // Connexion à la BDD

    public function init() {
        $db = new Database();
        
        return $db->getHandler();
    }

    // Edition de la requête

    public function setQuery($value) {
        $this->query = $value;
    }

    // Récupération de la requête

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

    /* Fonctions de sélections */

    // Sélection d'une ligne par un attribut

    public function fetchOne($attribute, $value) {
        $statement = $this->prepare();

        $statement->bindParam(":$attribute", $value);
        
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // Sélection de l'ensemble des lignes sans attribut

    public function fetchAll() {
        return $this->query()
                    ->fetchAll(PDO::FETCH_ASSOC);
    }

    // Sélection de l'ensemble des lignes par un attribut

    public function fetchAllWith($attribute, $value) {
        $statement = $this->prepare();

        $statement->bindParam(":$attribute", $value);
        
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nombre de lignes sans attributs

    public function withNone() {
        $statement = $this->prepare();

        $statement->execute();

        return $statement->fetchColumn();
    }

    // Nombre de lignes pour un ID

    public function withID($id) {
        $statement = $this->prepare();

        $statement->bindValue(":id", $id);

        $statement->execute();

        return $statement->fetchColumn();
    }

    // Nombre de ligne par valeurs

    public function withData($data) {
        $statement = $this->prepare();

        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();

        return $statement->fetchColumn();
    }

    // Association de valeurs

    public function bindValues($data) {
        $statement = $this->prepare();

        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        return $statement->execute();
    }
}