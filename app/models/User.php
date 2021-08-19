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
        $sql = "CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY AUTO_INCREMENT,
                    username VARCHAR(32) UNIQUE NOT NULL,
                    email VARCHAR(100) UNIQUE NOT NULL,
                    `password` VARCHAR(255) NOT NULL,
                    role VARCHAR(20) NOT NULL DEFAULT 'Membre',
                    created_at DATE DEFAULT CURRENT_TIMESTAMP,
                    banned BOOLEAN DEFAULT 0
                )";

        return $this->raw($sql);
    }

    // Suppression de la table

    public function drop() {
        return $this->raw("DROP TABLE IF EXISTS users");
    }

    // Sélection de l'ensemble des résultats

    public function findAll() {
        return $this->fetchAll("SELECT * FROM users");
    }

    // Nombre d'éléments de la table

    public function count() {
        return $this->fetchColumn("SELECT COUNT(id) FROM users");
    }

    // Sélection d'une ligne par un ID

    public function findById($id) {
        $sql = "SELECT * FROM users
                WHERE id = :id";

        return $this->fetchByID($sql, $id);
    }

    // Sélection d'un utilisateur par son pseudo

    public function findByName($username) {
        $sql = "SELECT * FROM users
                WHERE username = :username";

        return $this->fetchBy($sql, $username);
    }

    // Sélection d'un utilisateur par son e-mail

    public function findByEmail($email) {
        $sql = "SELECT * FROM users
                WHERE email = :email";

        return $this->fetchBy($sql, $email);
    }

    // Thèmes d'un utilisateur

    public function findThemes($userId) {
        $sql = "SELECT t.*
                FROM themes t, users u
                WHERE t.user_id = u.id
                AND u.id = :id";

        return $this->fetchAllById($sql, $userId);
    }

    // Nombre de thèmes d'un utilisateur

    public function countThemes($userId) {
        $themes = $this->findThemes($userId);

        return count($themes);
    }

    // Expressions d'un utilisateur

    public function findExpressions($userId) {
        $sql = "SELECT e.*
                FROM expressions e, users u
                WHERE e.user_id = u.id
                AND u.id = :id";

        return $this->fetchAllByID($sql, $userId);
    }

    // Nombre d'expressions d'un utilisateur

    public function countExpressions($userId) {
        $expressions = $this->findExpressions($userId);

        return count($expressions);
    }

    // Connexion d'un utilisateur

    public function login($email, $password) {
        $sql = "SELECT * FROM users
                WHERE email = :email";

        $row = $this->findBy($sql, "email", $email);

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

    // Rôle de modérateur

    public function isModerator($id) {
        $sql = "SELECT id FROM users
                WHERE role = 'Modérateur'
                AND id = :id";

        return $this->is($sql, $id);
    }

    // Rôle d'administrateur

    public function isAdmin($id) {
        $sql = "SELECT id FROM users
                WHERE role = 'Administrateur'
                AND id = :id";

        return $this->is($sql, $id);
    }

    // Rôle de modérateur ou d'administrateur

    public function isSuperUser($id) {
        $sql = "SELECT id FROM users
                WHERE role IN ('Modérateur', 'Administrateur')
                AND id = :id";

        return $this->is($sql, $id);
    }

    // Utilisateur banni

    public function isBanned($id) {
        $sql = "SELECT id FROM users
                WHERE banned
                AND id = :id";

        return $this->is($sql, $id);
    }

    // Ajout d'une nouvelle ligne

    public function insert($data) {
        $sql = "INSERT INTO users (username, email, password, role)
                VALUES (:username, :email, :password, :role)";

        return $this->withData($sql, $data);
    }

    // Edition d'un utilisateur existant

    // Changement de pseudo

    public function changeUsername($id, $username) {
        $sql = "UPDATE users
                SET username = :username
                WHERE id = :id";

        $data = [
            "id" => $id,
            "username" => $username
        ];

        return $this->withData($sql, $data);
    }

    // Changement d'e-mail

    public function changeEmail($id, $email) {
        $sql = "UPDATE users
                SET email = :email
                WHERE id = :id";

        $data = [
            "id" => $id,
            "email" => $email
        ];

        return $this->withData($sql, $data);
    }

    // Changement de mot de passe

    public function changePassword($id, $password) {
        $sql = "UPDATE users
                SET password = :password
                WHERE id = :id";

        $data = [
            "id" => $id,
            "password" => Security::hash($password)
        ];

        return $this->withData($sql, $data);
    }

    // Changement de rôle

    public function changeRole($id, $role) {
        $sql = "UPDATE users
                SET role = :role
                WHERE id = :id";

        $data = [
            "id" => $id,
            "role" => $role
        ];

        return $this->withData($sql, $data);
    }

    // Changement du statut de bannissement

    public function changeBanStatus($id, $banned) {
        $sql = "UPDATE users
                SET banned = :banned
                WHERE id = :id";

        $data = [
            "id" => $id,
            "banned" => $banned
        ];

        return $this->withData($sql, $data);
    }

    // Suppression d'une ligne par un ID

    public function delete($id) {
        $sql = "DELETE FROM users
                WHERE id = :id";

        return $this->withID($sql, $id);
    }
}