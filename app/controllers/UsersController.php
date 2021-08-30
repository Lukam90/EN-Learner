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

        // Edition

        $isSuperUser = false; 

        if (Session::isLoggedIn()) {
            $userId = Session::get("user_id");

            $isSuperUser = $this->userModel->isSuperUser($userId);
        }
        
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

            // Edition

            $canEdit = true;// $this->themeModel->belongsTo($userId, $themeId);

            // Enregistrement

            $users[] = [
                "id" => $userId,
                "username" => $username,
                "role" => $role,
                "color" => $color,
                "createdAt" => $createdAt,
                "nbThemes" => $nbThemes,
                "nbExpressions" => $nbExpressions,
                "canEdit" => $canEdit
            ];
        }

        // Rendu

        echo $this->twig->render("users.twig", [
            "session" => Session::all(),
            "superuser" => $isSuperUser,

            "users" => $users
        ]);

        Session::erase();
    }

    /**
     * Profil d'un utilisateur
     */

    public function profile($id) {
        Session::start();

        // Erreur si non connecté

        Session::errorIfNotLoggedIn();

        // Utilisateur connecté

        $userId = Session::get("user_id");

        // Même utilisateur

        if ($userId != $id) {
            Session::alert("Vous n'êtes pas autorisé(e) à accéder à cette page de profil utilisateur.");

            header("Location: http://localhost/en_app");

            return;
        }

        $user = $this->userModel->findOneById($id);

        $username = $user->username;
        $email = $user->email;
        $oldPassword = $user->password;

        // Stats

        $nbThemes = $this->userModel->countThemes($userId);
        $nbExpressions = $this->userModel->countExpressions($userId);

        // Rendu

        echo $this->twig->render("users/profile.twig", [
            "session" => Session::all(),

            "id" => $id,
            "username" => $username,
            "email" => $email,
            "oldPassword" => $oldPassword,

            "nbThemes" => $nbThemes,
            "nbExpressions" => $nbExpressions
        ]);

        Session::erase();
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

                    header("Location: http://localhost/en_app/users/login");

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

            $isEmpty = empty($email) || empty($password);

            if ($isEmpty) {
                Session::alert("Les champs doivent être renseignés.");

                header("Location: http://localhost/en_app/users/login");

                return;
            }

            $loggedIn = $this->userModel->login($email, $password);

            if ($loggedIn) {
                $errors["login"] = "";

                $user = $this->userModel->findOneByEmail($email);

                $isBanned = ($user->role === "Suspendu");

                // Utilisateur banni

                if ($isBanned) {
                    Session::errorIfBanned();
                }

                // Utilisateur autorisé

                Session::login($user);

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

        Session::erase();
    }

    /**
     * Déconnexion d'un utilisateur
     */

    public function logout() {
        Session::start();

        if (Session::isLoggedIn()) {
            Session::success("Vous êtes bien déconnecté(e).");
        } else {
            Session::alert("Vous êtes déjà déconnecté(e).");
        }

        Session::logout();

        header("Location: http://localhost/en_app");
    }

    /**
     * Edition d'un utilisateur
     */

    public function edit($id) {
        Session::start();

        // Utilisateur non connecté

        Session::errorIfNotLoggedIn();

        // Utilisateur inexistant

        Session::errorIfUserNotExists($id);

        // Utilisateur sélectionné

        $user = $this->userModel->findOneById($id);

        $id = $user->id;
        $username = $user->username;
        $role = $user->role;

        // Envoi des données

        if (Request::isPost()) {
            // Sécurité

            sleep(1);

            Session::errorIfNotToken();

            // Edition

            $role = Post::var("role");

            $saved = $this->userModel->changeRole($id, $role);

            if ($saved) {
                Session::success("Le rôle de l'utilisateur a bien été édité.");
            } else {
                Session::error();
            }

            header("Location: http://localhost/en_app/users");

            return;
        }

        // Rendu

        $roles = ["Suspendu", "Membre", "Modérateur", "Administrateur"];

        echo $this->twig->render("users/edit_user.twig", [
            "session" => Session::all(),

            "roles" => $roles,

            "id" => $id,
            "username" => $username,
            "role" => $role,
        ]);
    }

    /**
     * Suppression d'un utilisateur
     */

    public function delete($id) {
        Session::start();

        // Utilisateur non autorisé

        Session::errorIfNotSuperUser();

        // Utilisateur inexistant

        Session::errorIfUserNotExists($id);

        // Envoi des données

        if (Request::isPost()) {
            sleep(1);

            Session::errorIfNotToken();

            // Suppression

            $deleted = $this->userModel->delete($id);

            if ($deleted) {
                Session::success("L'utilisateur a bien été supprimé.");
            } else {
                Session::error();
            }

            header("Location: http://localhost/en_app/users");

            return;
        }

        // Rendu

        echo $this->twig->render("users/delete_user.twig", [
            "session" => Session::all(),
            "superuser" => $isSuperUser
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