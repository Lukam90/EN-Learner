<?php

namespace app\controllers;

use app\core\Request;
use app\core\Post;
use app\models\User;

use app\core\Session;
use app\models\Theme;
use app\models\Expression;
use app\controllers\Controller;

class UsersController extends Controller {
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
        $errors = [];
        $tips = [];
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
        $confirmPassword = "";

        // Indications

        $tips["username"] = "Le pseudo doit faire entre 2 et 32 caractères alphanumériques (espaces inclus).";
        $tips["email"] = "L'adresse e-mail doit être valide et peut comporter jusqu'à 100 caractères.";
        $tips["password"] = "Le mot de passe doit comporter 8 à 32 caractères alphanumériques, avec au moins une minuscule, une majuscule et un chiffre.";

        // Envoi du formulaire

        if (Request::isPost()) {
            var_dump(Post::var("email"));
            var_dump(Post::var("password"));
            var_dump(Post::var("confirmPassword"));

            // Pseudo

            if (Post::has("username")) {
                $username = Post::var("username");

                var_dump($username);
            } else {
                $errors["username"] = "Le pseudo doit être renseigné.";
            }

            // E-mail

            if (Post::has("email")) {
                $email = Post::var("email");

                var_dump($email);
            } else {
                $errors["email"] = "L'adresse e-mail doit être renseignée.";
            }

            // Mot de passe

            if (Post::has("password")) {
                $password = Post::hash("password");

                var_dump($password);
            } else {
                $errors["password"] = "Le mot de passe doit être renseigné.";
            }

            // Confirmation du mot de passe

            if (Post::has("confirm")) {
                $confirm = Post::hash("confirm");

                var_dump($confirm);
            } else {
                $errors["confirm"] = "Le mot de passe doit être confirmé.";
            }
        }

        // Rendu

        echo $this->twig->render("users/register.twig", [
            "success" => $success,
            "tips" => $tips,
            "errors" => $errors,
            "loggedIn" => $loggedIn
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
}