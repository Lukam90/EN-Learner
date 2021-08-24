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

    /**
     * Constructeur
     */

    public function __construct() {
        $this->init();

        $this->userModel = new User();
    }

    /**
     * Liste des utilisateurs
     */

    public function index() {
        Session::start();
        
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
            "session" => Session::all(),

            "users" => $users
        ]);
    }

    /**
     * Profil d'un utilisateur
     */

    public function profile() {
        Session::start();

        // Connexion

        // Rendu

        echo $this->twig->render("users/profile.twig", [
            "session" => Session::all(),

            "username" => "Lukas"
        ]);
    }

    /**
     * Inscription d'un utilisateur
     */

    public function register() {
        Session::start();

        // Utilisateur connecté

        Session::errorIfLoggedIn();

        // Validation

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
            sleep(1);

            $username = $validator->username();
            $email = $validator->email();
            $password = $validator->password();
            $confirm = $validator->confirm($password);

            // Validation

            $errors = $validator->getErrors();

            $valid = empty($errors["username"])
                     && empty($errors["email"])
                     && empty($errors["password"])
                     && empty($errors["confirm"]);

            // Enregistrement

            if ($valid) {
                $newUser = [
                    "username" => $username,
                    "email" => $email,
                    "password" => $password,
                    "role" => "Membre"
                ];

                $registered = $this->userModel->insert($newUser);

                if ($registered) {
                    Session::success("Votre inscription a été prise en compte avec succès. Bienvenue sur notre site, cher nouveau membre !");

                    $this->login();

                    Session::erase();

                    exit;
                } else {
                    Session::error();
                }
            }
        }

        // Rendu

        echo $this->twig->render("users/register.twig", [
            "session" => Session::all(),

            "tips" => $validator->getTips(),
            "errors" => $errors,

            "username" => $username,
            "email" => $email,
            "password" => $password,
            "confirm" => $confirm,
        ]);
    }

    /**
     * Connexion d'un utilisateur
     */

    public function login() {
        Session::start();

        // Erreur si utilisateur déjà connecté

        Session::errorIfLoggedIn();

        // Données du formulaire

        $email = "";
        $password = "";

        // Envoi du formulaire

        $errors = [];

        if (Request::isPost()) {
            sleep(1);

            $email = Post::var("email");
            $password = Post::var("password");

            $loggedIn = $this->userModel->login($email, $password);

            if ($loggedIn) {
                $errors["login"] = "";

                $currentUser = $this->userModel->findOneByEmail($email);

                $isBanned = $currentUser->banned;

                // Utilisateur banni

                if ($isBanned) {
                    Session::errorIfBanned();
                }

                // Utilisateur autorisé

                Session::login($currentUser);

                Session::redirectIfLoggedIn();
            } else {
                $errors["login"] = "Les identifiants sont incorrects. Veuillez réessayer.";
            }
        }

        // Rendu

        echo $this->twig->render("users/login.twig", [
            "session" => Session::all(),

            "errors" => $errors,

            "email" => $email,
            "password" => $password
        ]);
    }

    /**
     * Déconnexion d'un utilisateur
     */

    public function logout() {
        Session::start();

        if (! Session::isLoggedIn()) {
            Session::alert("Vous êtes déjà déconnecté(e).");
        }

        Session::logout();

        Session::erase();

        Redirection::home();
    }

    /**
     * Edition d'un utilisateur
     */

    public function edit() {
        Session::start();

        // Connexion

        // Rendu

        echo $this->twig->render("users/edit_user.twig", [
            "session" => Session::all(),

            "username" => "Lukas"
        ]);
    }

    /**
     * Suppression d'un utilisateur
     */

    public function delete() {
        Session::start();

        // Connexion

        // Rendu

        echo $this->twig->render("users/delete_user.twig", [
            "session" => Session::all(),

            "username" => "Lukas"
        ]);
    }

    /**
     * Demande de nouveau mot de passe
     */

    public function reset() {
        // Connexion

        // Rendu

        echo $this->twig->render("users/reset.twig", [
            "key" => "value"
        ]);
    }

    /**
     * Confirmation du nouveau mot de passe
     */

    public function confirm() {
        // Connexion

        // Rendu

        echo $this->twig->render("users/confirm.twig", [
            "key" => "value"
        ]);
    }
}