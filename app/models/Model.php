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

    // Création d'une table

    public function create() {
        return $this->dbHandler
                    ->exec("
                        CREATE TABLE IF NOT EXISTS {$this->tableName} (
                        {$this->definition}
                    )");
    }

    // Suppression d'une table

    public function drop() {
        return $this->dbHandler
                    ->exec("DROP TABLE IF EXISTS {$this->tableName}");
    }

    // Sélection de l'ensemble des résultats

    public function findAll() {
        return $this->dbHandler
                    ->query("SELECT * FROM {$this->tableName}")
                    ->fetchAll(\PDO::FETCH_OBJ);
    }

    // Sélection d'une ligne par un attribut

    public function findBy($attribute, $value) {
        $statement = $this->dbHandler
                          ->prepare("SELECT * FROM {$this->tableName}
                                     WHERE $attribute = :value");

        $statement->bindValue(":value", $value);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    // Sélection d'une ligne par un attribut avec ID

    public function is($id, $attribute, $value) {
        $statement = $this->dbHandler
                          ->prepare("SELECT id FROM {$this->tableName}
                                     WHERE id = :id
                                     AND $attribute = :value");

        $statement->bindValue(":id", $id);
        $statement->bindValue(":value", $value);
        $statement->execute();

        return $statement->fetchColumn() != 0;
    }

    // Nombre d'éléments d'une table

    public function count() {
        return $this->dbHandler->query("SELECT COUNT(id)
                                        FROM {$this->tableName}")
                               ->fetchColumn();
    }

    // Ajout d'une nouvelle ligne

    public function insert($data) {
        $values = $this->separate($data);

        return $this->dbHandler
                    ->exec("INSERT INTO {$this->tableName}
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