<?php

namespace app\models;

use app\core\Security;

use app\models\Model;

class User extends Model {
    // Initialisation de l'objet PDO

    public function __construct() {
        $this->dbHandler = $this->init();
    }

    // Création de la table

    public function create() {
        return $this->raw("CREATE TABLE IF NOT EXISTS users (
                           id INTEGER PRIMARY KEY AUTO_INCREMENT,
                           username VARCHAR(32) UNIQUE NOT NULL,
                           email VARCHAR(100) UNIQUE NOT NULL,
                           `password` VARCHAR(255) NOT NULL,
                           role VARCHAR(20) NOT NULL DEFAULT 'Membre',
                           created_at DATE DEFAULT CURRENT_TIMESTAMP,
                           banned BOOLEAN DEFAULT 0
                        )");
    }

    // Suppression de la table

    public function drop() {
        return $this->raw("DROP TABLE IF EXISTS users");
    }

    // Sélection de l'ensemble des résultats

    public function findAll() {
        return $this->fetchAll("SELECT * FROM users");
    }

    // Sélection d'une ligne par un ID

    public function findById($id) {
        return $this->findBy("SELECT * FROM users
                              WHERE id = :value",
                            $id);
    }

    // Sélection d'un utilisateur par son pseudo

    public function findByName($username) {
        return $this->findBy("SELECT * FROM users
                              WHERE username = :value",
                            $username);
    }

    // Sélection d'un utilisateur par son e-mail

    public function findByEmail($email) {
        return $this->findBy("SELECT * FROM users
                              WHERE email = :value",
                            $email);
    }

    // Nombre d'éléments de la table

    public function count() {
        return $this->fetchColumn("SELECT COUNT(id) FROM users");
    }

    // Ajout d'une nouvelle ligne

    public function insert($data) {
        $values = $this->separate($data);

        $statement = $this->dbHandler
                          ->prepare("INSERT INTO users
                                     SET (:username, :email, :password, :role)");

        $statement->bindValue(":username", $data["username"]);
        $statement->bindValue(":email", $username["email"]);
        $statement->bindValue(":password", Security::hash($username["password"]));
        $statement->bindValue(":role", $username["role"]);

        $statement->execute();
        
        return $this->raw("INSERT INTO users
                           SET $values");
    }

    // Thèmes d'un utilisateur

    public function findThemes($userId) {
        return $this->fetchAll("SELECT t.*
                                FROM themes t, users u
                                WHERE t.user_id = u.id
                                AND u.id = :id",
                                $userId
                              );
        /*
        $statement = $this->dbHandler
                          ->prepare("
                                SELECT t.*
                                FROM themes t, users u
                                WHERE t.user_id = u.id
                                AND u.id = :id
                            ");

        $statement->bindValue(":id", $userId);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
        */
    }

    // Nombre de thèmes d'un utilisateur

    public function countThemes($userId) {
        $themes = $this->findThemes($userId);

        return count($themes);
    }

    // Expressions d'un utilisateur

    public function findExpressions($userId) {
        $statement = $this->dbHandler
                          ->prepare("
                                SELECT e.*
                                FROM expressions e, users u
                                WHERE e.user_id = u.id
                                AND u.id = :id
                            ");

        $statement->bindValue(":id", $userId);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    // Nombre d'expressions d'un utilisateur

    public function countExpressions($userId) {
        $expressions = $this->findExpressions($userId);

        return count($expressions);
    }

    // Connexion d'un utilisateur

    public function login($email, $password) {
        $row = $this->findBy("email", $email);

        // On vérifie si les mots de passe correspondent

        if ($row) {
            $hashedPassword = $row->password;

            if (password_verify($password, $hashedPassword)) {
                return $row;
            } else {;
                return 0;
            }
        }
    }

    // Edition d'un utilisateur existant

    // Changement de pseudo

    public function changeUsername($id, $username) {
        return $this->update($id, ["username" => $username]);
    }

    // Changement d'e-mail

    public function changeEmail($id, $email) {
        return $this->update($id, ["email" => $email]);
    }

    // Changement de mot de passe

    public function changePassword($id, $password) {
        $password = password_hash($password, PASSWORD_BCRYPT);

        return $this->update($id, ["password" => $password]);
    }

    // Changement de rôle

    public function changeRole($id, $role) {
        return $this->update($id, ["role" => $role]);
    }

    // Changement du statut de bannissement

    public function changeBanStatus($id, $banned) {
        return $this->update($id, ["banned" => $banned]);
    }

    // Rôle de modérateur

    public function isModerator($id) {
        return $this->is("SELECT id FROM users
                   WHERE role = 'Modérateur'
                   AND id = :id",
                   $id
                );
    }

    // Rôle d'administrateur

    public function isAdmin($id) {
        return $this->is("SELECT id FROM users
                          WHERE role = 'Administrateur'
                          AND id = :id",
                          $id
                        );
    }

    // Rôle de modérateur ou d'administrateur

    public function isSuperUser($id) {
        return $this->is("SELECT id FROM users
                          WHERE role IN ('Modérateur', 'Administrateur')
                          AND id = :id",
                          $id
                        );
    }

    // Utilisateur banni

    public function isBanned($id) {
        return $this->is("SELECT id FROM users
                          WHERE banned
                          AND id = :id",
                          $id
                        );
    }
}