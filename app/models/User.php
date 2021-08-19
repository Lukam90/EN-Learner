<?php

namespace app\models;

use PDO;

use app\core\Security;

use app\models\Model;

class User extends Model {
    // Initialisation de l'objet PDO

    public function __construct() {
        $this->dbHandler = $this->init();
    }

    // Création de la table

    public function create() {
        return $this->run("CREATE TABLE IF NOT EXISTS users (
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
        return $this->dropTable("users");
    }

    // Sélection de l'ensemble des résultats

    public function findAll() {
        return $this->selectAll("users");
    }

    // Nombre d'éléments de la table

    public function count() {
        return $this->countLines("users");
    }

    // Sélection d'une ligne par un ID

    public function findById($id) {
        $query = "SELECT *
                  FROM users
                  WHERE id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);

        return $statement->execute();
    }

    // Sélection d'un utilisateur par son pseudo

    public function findByName($username) {
        $query = "SELECT *
                  FROM users
                  WHERE username = :username";

        $statement = $this->prepare($query);

        $statement->bindValue(":username", $username);

        return $statement->execute();
    }

    // Sélection d'un utilisateur par son e-mail

    public function findByEmail($email) {
        $query = "SELECT *
                  FROM users
                  WHERE email = :email";

        $statement = $this->prepare($query);

        $statement->bindValue(":email", $email);

        return $statement->execute();
    }

    // Thèmes d'un utilisateur

    public function findThemes($userId) {
        $query = "SELECT t.*
                  FROM themes t, users u
                  WHERE t.user_id = u.id
                  AND u.id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $userId);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    // Nombre de thèmes d'un utilisateur

    public function countThemes($userId) {
        $themes = $this->findThemes($userId);

        return count($themes);
    }

    // Expressions d'un utilisateur

    public function findExpressions($userId) {
        $query = "SELECT e.*
                  FROM expressions e, users u
                  WHERE e.user_id = u.id
                  AND u.id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $userId);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    // Nombre d'expressions d'un utilisateur

    public function countExpressions($userId) {
        $expressions = $this->findExpressions($userId);

        return count($expressions);
    }

    // Connexion d'un utilisateur

    public function login($email, $password) {
        $query = "SELECT email, password
                  FROM users
                  WHERE email = :email";

        $statement = $this->prepare($query);

        $statement->bindValue(":email", $email);

        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_OBJ);

        // On vérifie si les mots de passe correspondent

        if ($row) {
            $hashedPassword = $row->password;

            return password_verify($password, $hashedPassword);
        } else {
            return false;
        }
    }

    // Rôle de modérateur

    public function isModerator($id) {
        $query = "SELECT id 
                  FROM users
                  WHERE role = 'Modérateur'
                  AND id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);

        return $statement->execute();
    }

    // Rôle d'administrateur

    public function isAdmin($id) {
        $query = "SELECT id 
                  FROM users
                  WHERE role = 'Administrateur'
                  AND id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);

        return $statement->execute();
    }

    // Rôle de modérateur ou d'administrateur

    public function isSuperUser($id) {
        $query = "SELECT id 
                  FROM users
                  WHERE role IN ('Modérateur', 'Administrateur')
                  AND id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);

        return $statement->execute();
    }

    // Utilisateur banni

    public function isBanned($id) {
        $query = "SELECT id
                  FROM users
                  WHERE banned
                  AND id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);

        return $statement->execute();
    }

    // Ajout d'une nouvelle ligne

    public function insert($data) {
        $query = "INSERT INTO users (username, email, password, role)
                  VALUES (:username, :email, :password, :role)";

        $statement = $this->prepare($query);

        $statement->bindValue(":username", $username);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":password", Security::hash($password));
        $statement->bindValue(":role", $role);

        return $statement->execute();
    }

    // Edition d'un utilisateur existant

    // Changement de pseudo

    public function changeUsername($id, $username) {
        $query = "UPDATE users
                  SET username = :username
                  WHERE id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);
        $statement->bindValue(":username", $username);

        return $statement->execute();
    }

    // Changement d'e-mail

    public function changeEmail($id, $email) {
        $query = "UPDATE users
                  SET email = :email
                  WHERE id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);
        $statement->bindValue(":email", $email);

        return $statement->execute();
    }

    // Changement de mot de passe

    public function changePassword($id, $password) {
        $query = "UPDATE users
                  SET password = :password
                  WHERE id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);
        $statement->bindValue(":password", $password);

        return $statement->execute();
    }

    // Changement de rôle

    public function changeRole($id, $role) {
        $query = "UPDATE users
                  SET role = :role
                  WHERE id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);
        $statement->bindValue(":role", $role);

        return $statement->execute();
    }

    // Changement du statut de bannissement

    public function changeBanStatus($id, $banned) {
        $query = "UPDATE users
                  SET banned = :banned
                  WHERE id = :id";

        $statement = $this->prepare($query);

        $statement->bindValue(":id", $id);
        $statement->bindValue(":banned", $banned);

        return $statement->execute();
    }

    // Suppression d'une ligne par un ID

    public function delete($id) {
        return $this->deleteLine("users");
    }
}