<?php

namespace app\models;

use app\core\Database;
use app\core\Security;

abstract class Model {
    protected $dbHandler;
    protected $tableName;
    protected $definition;

    // Initialisation de l'objet PDO
    // -> Connexion à la BDD

    public function init() {
        $db = new Database();
        
        return $db->getHandler();
    }

    // Séparation de valeurs

    public function separate($data) {
        $index = 0;
        $length = count($data) - 1;

        $values = "";

        foreach ($data as $key => $value) {
            $type = gettype($value);
            $values .= "$key = ";

            $values .= ($type === "string") ? "\"$value\"" : "$value";

            if ($index < $length) {
                $values .= ", ";
            }

            $index++;
        }

        return $values;
    }

    // Chargement de données de tests (CSV)

    public function loadCSV($attributes) {
        $length = 0;
        $data = [];

        $file = fopen("{$this->tableName}.csv", "r");
        
        while(! feof($file)) {
            $line = Security::clean(fgets($file));
            
            $values = explode(";", $line);

            $index = 0;

            foreach ($attributes as $key) {
                $value = $values[$index];

                if ($key == "password") {
                    $value = password_hash($value, PASSWORD_BCRYPT);
                }

                $data[$length][$key] = $value;

                $index++;
            }

            $length++;
        }
        
        fclose($file);
        
        return $data;
    }

    // Requête générale brute (ex : création)

    public function raw($query) {
        return $this->dbHandler
                    ->exec($query);
    }

    // Suppression d'une table

    /*public function drop($tableName) {
        return $this->dbHandler
                    ->exec("DROP TABLE IF EXISTS $tableName");
    }*/

    // Sélection de l'ensemble des résultats

    public function fetchAll($query) {
        return $this->dbHandler
                    ->query($query)
                    ->fetchAll(\PDO::FETCH_OBJ);
    }

    // Sélection d'une colonne (ex : nombre)

    public function fetchColumn($query) {
        return $this->dbHandler->query($query)
                               ->fetchColumn();
    }

    // Sélection d'une ligne par un attribut

    public function findBy($query, $value) {
        $statement = $this->dbHandler
                          ->prepare($query);

        $statement->bindParam(":value", $value);
        
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    // Vérification d'une ligne par un attribut avec ID

    public function is($query, $id) {
        $statement = $this->dbHandler
                          ->prepare($query);

        $statement->bindValue(":id", $id);

        $statement->execute();

        return $statement->fetchColumn() != 0;
    }

    // Ajout d'une nouvelle ligne

    public function insert($tableName, $data) {
        $values = $this->separate($data);

        return $this->dbHandler
                    ->exec("INSERT INTO $tableName
                            SET $values");
    }

    // Changement de valeurs par un ID

    public function update($id, $data) {
        $values = $this->separate($data);

        $statement = $this->dbHandler
                          ->prepare("UPDATE {$this->tableName}
                                     SET $values
                                     WHERE id = :id");

        $statement->bindValue(":id", $id);

        return $statement->execute();
    }

    // Suppression d'une ligne par un ID

    public function delete($id) {
        $statement = $this->dbHandler
                          ->prepare("DELETE FROM {$this->tableName}
                                     WHERE id = :id");

        $statement->bindValue(":id", $id);

        return $statement->execute();
    }
}