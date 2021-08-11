<?php

namespace app\controllers;

use app\core\Post;
use app\models\User;
use app\core\Request;
use app\core\Session;

use app\core\Constants;

use app\core\Validation;
use app\controllers\Controller;

class UsersController extends Controller {
    // Modèle (User)

    private $userModel;

    // Constructeur

    public function __construct() {
        $this->init();

        $this->userModel = new User();
    }

    // Liste des utilisateurs

    public function index() {
        // Données

        $list = $this->userModel->findAll();

        $users = [];

        $index = 0;

        foreach ($list as $user) {
            // Lecture

            $userId = $user->id;
            $username = $user->username;
            $role = $user->role;

            $createdAt = new \DateTime($user->created_at);
            $createdAt = $createdAt->format("d/m/Y");

            $nbThemes = $this->userModel->countThemes($userId);
            $nbExpressions = $this->userModel->countExpressions($userId);

            // Couleur / Rôle

            $color = "";

            if ($role == "Administrateur") {
                $color = "w3-text-red";
            } else if ($role == "Modérateur") {
                $color = "w3-text-green";
            }

            // Enregistrement

            $users[$index]["id"] = $userId;
            $users[$index]["username"] = $username;
            $users[$index]["role"] = $role;
            $users[$index]["color"] = $color;
            $users[$index]["createdAt"] = $createdAt;
            $users[$index]["nbThemes"] = $nbThemes;
            $users[$index]["nbExpressions"] = $nbExpressions;

            $index++;
        }

        // Rendu

        echo $this->twig->render("users.twig", [
            "users" => $users
        ]);
    }

    // Profil d'un utilisateur

    public function profile() {
        // Connexion

        // Rendu

        echo $this->twig->render("users/profile.twig", [
            "username" => "Lukas"
        ]);
    }

    // Inscription d'un utilisateur

    public function register() {
        $success = [];
        $page = "";

        // Utilisateur connecté

        $loggedIn = Session::has("user_id");

        /* Validation */

        // Invités seulement

        $valid = ! $loggedIn;

        // Données du formulaire

        $username = "";
        $email = "";
        $password = "";
        $confirm = "";

        // Indications

        $this->tips["username"] = Validation::TIP_USERNAME;
        $this->tips["email"] = Validation::TIP_EMAIL;
        $this->tips["password"] = Validation::TIP_PASSWORD;

        // Envoi du formulaire

        if (Request::isPost()) {
            var_dump($_POST);

            // Pseudo

            $username = $this->validateUsername();

            // E-mail

            $email = $this->validateEmail();

            // Mot de passe

            $password = $this->validatePassword();

            // Confirmation du mot de passe

            if (! Post::empty("confirm")) {
                $confirm = Post::var("confirm");

                var_dump($confirm);
            } else {
                $this->errors["confirm"] = "Le mot de passe doit être confirmé.";
            }
        }

        // Rendu

        echo $this->twig->render("users/register.twig", [
            "success" => $success,
            "tips" => $this->tips,
            "errors" => $this->errors,
            "loggedIn" => $loggedIn,

            "username" => $username,
            "email" => $email,
            "password" => $password,
            "confirm" => $confirm
        ]);
    }

    // Connexion d'un utilisateur

    public function login() {
        // 

        // Rendu

        echo $this->twig->render("users/login.twig", [
            "key" => "value"
        ]);
    }

    // Edition d'un utilisateur

    public function edit() {
        // Connexion

        // Rendu

        echo $this->twig->render("users/edit_user.twig", [
            "username" => "Lukas"
        ]);
    }

    // Suppression d'un utilisateur

    public function delete() {
        // Connexion

        // Rendu

        echo $this->twig->render("users/delete_user.twig", [
            "username" => "Lukas"
        ]);
    }

    // Demande de nouveau mot de passe

    public function reset() {
        // Connexion

        // Rendu

        echo $this->twig->render("users/reset.twig", [
            "key" => "value"
        ]);
    }

    // Confirmation du nouveau mot de passe

    public function confirm() {
        // Connexion

        // Rendu

        echo $this->twig->render("users/confirm.twig", [
            "key" => "value"
        ]);
    }

    /* Validation des données */

    // Pseudo

    public function validateUsername() {
        $username = "";

        if (! Post::empty("username")) {
            $username = Post::var("username");

            $regex = "/^[a-z0-9\s]{2,32}$/i";
    
            if (preg_match($regex, $username)) {
                $exists = $this->userModel->findByName($username);
    
                if (! $exists) {
                    $this->tips["username"] = "";
                } else {
                    $this->errors["username"] = "Le pseudo existe déjà. Veuillez en choisir un autre.";
                }
            } else {
                $this->errors["username"] = "Le pseudo doit être valide.";
            }
        } else {
            $this->errors["username"] = "Le pseudo doit être renseigné.";
        }

        return $username;
    }

    // E-mail

    public function validateEmail() {
        $email = "";

        if (! Post::empty("email")) {
            $email = Post::var("email");

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $exists = $this->userModel->findByEmail($email);

                $this->tips["email"] = "";
    
                if ($exists) {
                    $this->errors["email"] = "Un compte existe déjà avec cette adresse e-mail. Veuillez en saisir une nouvelle.";
                }
            } else {
                $this->errors["email"] = "L'adresse e-mail doit être valide.";
            }
        } else {
            $this->errors["email"] = "L'adresse e-mail doit être renseignée.";
        }

        return $email;
    }

    public function validatePassword() {
        $password = "";

        if (! Post::empty("password")) {
            $password = Post::var("password");

            $length = strlen($password);

            $hasLength = $length >= 8 && $length <= 32;

            if ($hasLength) {
                $hasLowerCase = preg_match("/[a-z]+/", $password);
                $hasUpperCase = preg_match("/[A-Z]+/", $password);
                $hasDigit = preg_match("/[0-9]+/", $password);

                $matches = $hasLowerCase && $hasUpperCase && $hasDigit;

                if ($matches) {
                    $this->tips["password"] = "";
                } else {
                    $this->errors["password"] = "Le mot de passe doit contenir au moins une minuscule, une majuscule et un chiffre.";
                }
            } else {
                $this->errors["password"] = "Le mot de passe doit contenir entre 8 et 32 caractères.";
            }
        } else {
            $this->errors["password"] = "Le mot de passe doit être renseigné.";
        }

        return $password;
    }

    // Confirmation du mot de passe

    public function validateConfirm($password) {
        $confirm = "";

        if (! Post::empty("confirm")) {
            $confirm = Post::var("confirm");
    
            if ($confirm === $password) {

            } else {
                $this->errors["confirm"] = "";
            }
        } else {
            $this->errors["confirm"] = "Le mot de passe doit être confirmé.";
        }

        return $confirm;
    }
}