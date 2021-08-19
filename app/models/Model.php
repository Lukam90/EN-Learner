<?php

namespace app\models;

use app\core\Database;
use app\core\Security;

abstract class Model {
    protected $dbHandler;

    // Initialisation de l'objet PDO
    // Connexion à la BDD

    public function init() {
        $db = new Database();
        
        return $db->getHandler();
    }

    // Chargement de données de tests (CSV)

    public function loadCSV($tableName, $attributes) {
        $length = 0;
        $data = [];

        $file = fopen("$tableName.csv", "r");
        
        while(! feof($file)) {
            $line = Security::clean(fgets($file));
            
            $values = explode(";", $line);

            $index = 0;

            foreach ($attributes as $key) {
                $value = $values[$index];

                $data[$length][$key] = $value;

                $index++;
            }

            $length++;
        }
        
        fclose($file);
        
        return $data;
    }

    // Requête générale brute (ex : création)

    public function raw($sql) {
        return $this->dbHandler
                    ->exec($sql);
    }

    // Requête préparée

    public function prepare($sql) {
        return $this->dbHandler
                    ->prepare($sql);
    }

    // Requête générale

    public function query($sql) {
        return $this->dbHandler
                    ->query($sql);
    }

    // Requête préparée avec un attribut

    public function withAttribute($sql, $attribute, $value) {
        $statement = $this->prepare($sql);

        $statement->bindValue(":$attribute", $value);

        return $statement->execute();
    }

    // Requête préparée avec un ID

    public function withID($sql, $id) {
        return $this->withAttribute($sql, "id", $id);
    }

    // Requête préparée avec données

    public function withData($sql, $data) {
        $statement = $this->prepare($sql);

        foreach ($data as $key => $value) {
            if ($key == "password") {
                $value = Security::hash($value);
            }

            $statement->bindValue(":$key", $value);
        }

        return $statement->execute();
    }

    // Sélection de l'ensemble des résultats

    public function fetchAll($sql) {
        return $this->query($sql)
                    ->fetchAll(\PDO::FETCH_OBJ);
    }

    // Sélection d'une colonne (ex : nombre)

    public function fetchColumn($sql) {
        return $this->query($sql)
                    ->fetchColumn();
    }

    // Sélection d'une ligne par un attribut

    public function fetchBy($sql, $attribute, $value) {
        $statement = $this->prepare($sql);

        $statement->bindParam(":$attribute", $value);
        
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    // Sélection d'une ligne par un ID

    public function fetchByID($sql, $id) {
        return $this->fetchBy($sql, "id", $id);
    }

    // Sélection de l'ensemble des lignes par un attribut

    public function fetchAllBy($sql, $attribute, $value) {
        $statement = $this->prepare($sql);

        $statement->bindParam(":$attribute", $value);
        
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    // Sélection de l'ensemble des lignes par un ID

    public function fetchAllByID($sql, $id) {
        return fetchAllBy($sql, "id", $id);
    }

    // Vérification d'une ligne par un attribut avec ID

    public function is($sql, $id) {
        $statement = $this->prepare($sql);

        $statement->bindValue(":id", $id);

        $statement->execute();

        return $statement->fetchColumn() != 0;
    }
}