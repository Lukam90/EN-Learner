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
        $this->setQuery("CREATE TABLE IF NOT EXISTS users (
                            id INTEGER PRIMARY KEY AUTO_INCREMENT,
                            username VARCHAR(32) UNIQUE NOT NULL,
                            email VARCHAR(100) UNIQUE NOT NULL,
                            `password` VARCHAR(255) NOT NULL,
                            role VARCHAR(20) NOT NULL DEFAULT 'Membre',
                            created_at DATE DEFAULT CURRENT_TIMESTAMP,
                            banned BOOLEAN DEFAULT 0
                        )");

        return $this->run();
    }

    // Suppression de la table

    public function drop() {
        $this->setQuery("DROP TABLE IF EXISTS users");

        return $this->run();
    }

    // Sélection de l'ensemble des résultats

    public function findAll() {
        $this->setQuery("SELECT * FROM users");

        return $this->fetchAll();
    }

    // Nombre d'éléments de la table

    public function count() {
        $this->setQuery("SELECT COUNT(id) FROM users");

        return $this->withNone();
    }

    // Sélection d'une ligne par un ID

    public function findOneById($id) {
        $this->setQuery("SELECT *
                         FROM users
                         WHERE id = :id");

        return $this->fetchOne("id", $id);
    }

    // Sélection d'un utilisateur par son pseudo

    public function findOneByName($username) {
        $this->setQuery("SELECT *
                         FROM users
                         WHERE username = :username");

        return $this->fetchOne("username", $username);
    }

    // Sélection d'un utilisateur par son e-mail

    public function findOneByEmail($email) {
        $this->setQuery("SELECT *
                         FROM users
                         WHERE email = :email");

        return $this->fetchOne("email", $email);
    }

    // Thèmes d'un utilisateur

    public function findThemes($userId) {
        $this->setQuery("SELECT t.*
                         FROM themes t, users u
                         WHERE t.user_id = u.id
                         AND u.id = :id");

        return $this->fetchAllWith("id", $userId);
    }

    // Nombre de thèmes d'un utilisateur

    public function countThemes($userId) {
        $this->setQuery("SELECT COUNT(t.id)
                         FROM themes t, users u
                         WHERE t.user_id = u.id
                         AND u.id = :id");

        return $this->withID($userId);
    }

    // Expressions d'un utilisateur

    public function findExpressions($userId) {
        $this->setQuery("SELECT e.*
                         FROM expressions e, users u
                         WHERE e.user_id = u.id
                         AND u.id = :id");

        return $this->fetchAllWith("id", $userId);
    }

    // Nombre d'expressions d'un utilisateur

    public function countExpressions($userId) {
        $this->setQuery("SELECT COUNT(e.id)
                         FROM expressions e, users u
                         WHERE e.user_id = u.id
                         AND u.id = :id");

        return $this->withID($userId);
    }

    // Connexion d'un utilisateur

    public function login($email, $password) {
        $row = $this->findOneByEmail($email);

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
        $this->setQuery("SELECT COUNT(id) 
                         FROM users
                         WHERE role = 'Modérateur'
                         AND id = :id");

        return (bool) $this->withID($id);
    }

    // Rôle d'administrateur

    public function isAdmin($id) {
        $this->setQuery("SELECT id 
                         FROM users
                         WHERE role = 'Administrateur'
                         AND id = :id");

        return (bool) $this->withID($id);
    }

    // Rôle de modérateur ou d'administrateur

    public function isSuperUser($id) {
        $this->setQuery("SELECT id 
                         FROM users
                         WHERE role IN ('Modérateur', 'Administrateur')
                         AND id = :id");

        return (bool) $this->withID($id);
    }

    // Utilisateur banni

    public function isBanned($id) {
        $this->setQuery("SELECT id
                         FROM users
                         WHERE banned
                         AND id = :id");

        return $this->withID($id);
    }

    // Ajout d'une nouvelle ligne

    public function insert($data) {
        $this->setQuery("INSERT INTO users (username, email, password, role)
                         VALUES (:username, :email, :password, :role)");

        $data["password"] = Security::hash($data["password"]);

        return $this->bindValues($data);
    }

    // Edition d'un utilisateur existant

    // Changement de pseudo

    public function changeUsername($id, $username) {
        $this->setQuery("UPDATE users
                         SET username = :username
                         WHERE id = :id");

        $data = [
            "id" => $id,
            "username" => $username
        ];

        return $this->bindValues($data);
    }

    // Changement d'e-mail

    public function changeEmail($id, $email) {
        $this->setQuery("UPDATE users
                         SET email = :email
                         WHERE id = :id");

        $data = [
            "id" => $id,
            "email" => $email
        ];

        return $this->bindValues($data);
    }

    // Changement de mot de passe

    public function changePassword($id, $password) {
        $this->setQuery("UPDATE users
                         SET password = :password
                         WHERE id = :id");

        $data = [
            "id" => $id,
            "password" => Security::hash($password)
        ];

        return $this->bindValues($data);
    }

    // Changement de rôle

    public function changeRole($id, $role) {
        $this->setQuery("UPDATE users
                         SET role = :role
                         WHERE id = :id");

        $data = [
            "id" => $id,
            "role" => $role
        ];

        return $this->bindValues($data);
    }

    // Changement du statut de bannissement

    public function changeBanStatus($id, $banned) {
        $this->setQuery("UPDATE users
                         SET banned = :banned
                         WHERE id = :id");

        $data = [
            "id" => $id,
            "banned" => $banned
        ];

        return $this->bindValues($data);
    }

    // Suppression d'une ligne par un ID

    public function delete($id) {
        $this->setQuery("DELETE FROM users
                         WHERE id = :id");

        $data = ["id" => $id];

        return $this->bindValues($data);
    }
}