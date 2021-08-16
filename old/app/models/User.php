<?php

namespace app\models;

use app\models\Model;

use app\core\Security;

class User extends Model {
    // Initialisation de l'objet PDO

    public function __construct() {
        $this->dbHandler = $this->init();
        $this->tableName = "users";
        $this->definition = "
            id INTEGER PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(32) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            role VARCHAR(20) NOT NULL DEFAULT 'Membre',
            created_at DATE DEFAULT CURRENT_TIMESTAMP,
            banned BOOLEAN DEFAULT 0
        ";
    }

    // Sélection d'un utilisateur par son pseudo

    public function findByName($username) {
        return $this->findBy("username", $username);
    }

    // Sélection d'un utilisateur par son e-mail

    public function findByEmail($email) {
        return $this->findBy("email", $email);
    }

    // Thèmes d'un utilisateur

    public function findThemes($userId) {
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
        return $this->is($id, "role", "Modérateur");
    }

    // Rôle d'administrateur

    public function isAdmin($id) {
        return $this->is($id, "role", "Administrateur");
    }

    // Rôle de modérateur ou d'administrateur

    public function isSuperUser($id) {
        return $this->isModerator($id) || $this->isAdmin($id);
    }

    // Utilisateur banni

    public function isBanned($id) {
        return $this->is($id, "banned", 1);
    }
}