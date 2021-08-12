<?php

namespace app\controllers;

use app\core\Post;
use app\core\Request;
use app\core\Session;
use app\core\Security;
use app\core\Redirection;

use app\models\User;

use app\controllers\Controller;

use app\validation\UserValidation;

class UsersController extends Controller {
    // Attributs

    private $userModel; // Modèle (User)

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

            $users[] = [
                "id" => $userId,
                "username" => $username,
                "role" => $role,
                "color" => $color,
                "createdAt" => $createdAt,
                "nbThemes" => $nbThemes,
                "nbExpressions" => $nbExpressions
            ];
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
        // Utilisateur connecté

        $loggedIn = Session::has("user_id");

        /* Validation */

        $validator = new UserValidation();

        // Indications

        $validator->setTip("username", "Le pseudo doit faire entre 2 et 32 caractères alphanumériques (espaces inclus).");
        $validator->setTip("email", "L'adresse e-mail doit être valide et peut comporter jusqu'à 100 caractères.");
        $validator->setTip("password", "Le mot de passe doit comporter 8 à 32 caractères alphanumériques, avec au moins une minuscule, une majuscule et un chiffre.");

        // Données du formulaire

        $username = "";
        $email = "";
        $password = "";
        $confirm = "";

        // Envoi du formulaire

        $errors = [];

        if (Request::isPost()) {
            var_dump($_POST);

            $username = $validator->username();
            $email = $validator->email();
            $password = $validator->password();
            $confirm = $validator->confirm($password);

            // Validation

            $errors = $validator->getErrors();

            $valid = empty($errors) && ! $loggedIn;

            // Enregistrement

            if ($valid) {
                $hashedPassword = Security::hash($password);

                $newUser = [
                    "username" => $username,
                    "email" => $email,
                    "password" => $hashedPassword
                ];

                $registered = $this->userModel->insert($newUser);

                if ($registered) {
                    Session::set("success", "Votre inscription a été prise en compte avec succès. Bienvenue sur notre site, cher nouveau membre !");

                    //header("Location : ./");
                } else {
                    Session::set("alert", "Une erreur s'est produite. Veuillez contacter l'administrateur du site.");
                }
            }
        }

        // Rendu

        echo $this->twig->render("users/register.twig", [
            "tips" => $validator->getTips(),
            "errors" => $errors,
            "loggedIn" => $loggedIn,

            "username" => $username,
            "email" => $email,
            "password" => $password,
            "confirm" => $confirm,
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

    // Déconnexion d'un utilisateur

    public function logout() {
        // 

        // Redirection vers la page d'accueil

        Redirection::home();
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