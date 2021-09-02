<?php

namespace app\controllers;

use app\core\Post;
use app\core\Request;
use app\core\Session;
use app\core\Security;
use app\core\Redirection;

use app\models\User;

use app\controllers\ModelController;

use app\validation\UserValidation;

class UsersController extends ModelController {
    // Constantes

    const TIP_USERNAME = "Le pseudo doit faire entre 2 et 32 caractères alphanumériques (espaces inclus).";
    const TIP_EMAIL = "L'adresse e-mail doit être valide et peut comporter jusqu'à 100 caractères.";
    const TIP_PASSWORD = "Le mot de passe doit comporter 8 à 32 caractères alphanumériques, avec au moins une minuscule, une majuscule et un chiffre.";

    // Constructeur

    public function __construct() {
        $this->init();

        $this->userModel = new User();
        $this->validator = new UserValidation();
    }

    /**
     * Fonctions utilitaires
     */

    // Indications

    public function setTips() {
        $validator->setTip("username", self::TIP_USERNAME);
        $validator->setTip("email", self::TIP_EMAIL);
        $validator->setTip("password", self::TIP_PASSWORD);
    }

    // Ensemble des utilisateurs

    public function getAllUsers() {
        return $this->userModel->findAll();
    }

    // Sélection d'un utilisateur (ID)

    public function getOneUser($userId) {
        return $this->userModel->findOneById($userId);
    }

    // Nombre de thèmes

    public function getNbThemes($userId) {
        return $this->userModel->countThemes($userId);
    }

    // Nombre d'expressions

    public function getNbExpressions($userId) {
        return $this->userModel->countExpressions($userId);
    }

    /* Validation */

    // Pseudo

    public function getCheckedUsername() {
        return $this->validator->checkUsername();
    }

    // Adresse e-mail

    public function getCheckedEmail() {
        return $this->validator->checkEmail();
    }

    // Mot de passe

    public function getCheckedPassword() {
        return $this->validator->checkPassword();
    }

    // Confirmation du mot de passe

    public function getCheckedConfirm($password) {
        return $this->validator->checkConfirm($password);
    }

    /*
    
    // 

    public function () {
        
    }

    // 

    public function () {
        
    }

    // 

    public function () {
        
    }

    // 

    public function () {
        
    }

    // 

    public function () {
        
    }

    // 

    public function () {
        
    }
    */

    /**
     * Liste des utilisateurs
     */

    public function index() {
        Session::start();

        // Edition

        $isSuperUser = false; 

        if (Session::isLoggedIn()) {
            $isSuperUser = $this->isSuperUser();
        }
        
        // Données

        $list = $this->getAllUsers();

        $users = [];

        foreach ($list as $user) {
            // Lecture

            $userId = $user->id;

            $username = $user->username;
            $role = $user->role;

            $createdAt = new \DateTime($user->created_at);
            $createdAt = $createdAt->format("d/m/Y");

            $nbThemes = $this->getNbThemes($userId);
            $nbExpressions = $this->getNbExpressions($userId);

            // Couleur / Rôle

            $color = "";

            if ($role == "Administrateur") {
                $color = "red";
            } else if ($role == "Modérateur") {
                $color = "green";
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

        $this->render("users.twig", [
            "session" => Session::all(),
            "superuser" => $isSuperUser,

            "pageTitle" => "Communauté",

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

        $this->notLoggedIn();

        // Utilisateur connecté

        $userId = Session::get("user_id");

        // Même utilisateur

        if ($userId != $id) {
            Session::alert("Vous n'êtes pas autorisé(e) à accéder à cette page de profil utilisateur.");

            Redirection::to("/");

            return;
        }

        $user = $this->getOneUser($id);

        $username = $user->username;
        $email = $user->email;
        $oldPassword = $user->password;

        // Stats

        $nbThemes = $this->userModel->countThemes($userId);
        $nbExpressions = $this->userModel->countExpressions($userId);

        // Rendu

        $this->render("users/profile.twig", [
            "session" => Session::all(),

            "pageTitle" => "Profil de l'utilisateur $username",

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

        // Invité / Utilisateur non connecté

        $this->isGuest();

        // Indications

        $this->setTips();

        // Données du formulaire

        $username = "";
        $email = "";
        $password = "";
        $confirm = "";

        // Envoi du formulaire

        $errors = [];

        if (Request::isPost()) {
            sleep(1);

            $username = $this->validator->checkUsername();
            $email = $this->validator->checkEmail();
            $password = $this->validator->checkPassword();
            $confirm = $this->validator->checkConfirm($password);

            // Validation

            $errors = $this->getErrors();

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

                    Redirection::to("/users/login");

                    exit;
                } else {
                    Session::error();
                }
            }
        }

        // Rendu

        $this->render("users/register.twig", [
            "session" => Session::all(),

            "tips" => $this->getTips(),
            "errors" => $errors,

            "pageTitle" => "Inscription",

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

                Redirection::to("/users/login");

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

        $this->render("users/login.twig", [
            "session" => Session::all(),

            "errors" => $errors,

            "pageTitle" => "Connexion",

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

        Redirection::to("/");
    }

    /**
     * Edition d'un utilisateur
     */

    public function edit($id) {
        Session::start();

        // Utilisateur non connecté

        $this->notLoggedIn();

        // Utilisateur inexistant

        Session::errorIfUserNotExists($id);

        // Utilisateur sélectionné

        $user = $this->getOneUser($id);

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

            Redirection::to("/users");

            return;
        }

        // Rendu

        $roles = ["Suspendu", "Membre", "Modérateur", "Administrateur"];

        $this->render("users/edit_user.twig", [
            "session" => Session::all(),

            "roles" => $roles,
            "label" => "Editer",

            "pageTitle" => "Edition du statut de $username",

            "id" => $id,
            "username" => $username,
            "role" => $role,
        ]);
    }

    /**
     * Suppression d'un utilisateur
     */

    public function delete($userId) {
        Session::start();

        // Utilisateur non autorisé

        Session::errorIfNotSuperUser();

        // Utilisateur inexistant

        Session::errorIfUserNotExists($userId);

        // Utilisateur existant

        $user = $this->getOneUser($userId);

        $username = $user->username;

        $nbThemes = $this->getNbThemes($userId);
        $nbExpressions = $this->getNbExpressions($userId);

        // Envoi des données

        if (Request::isPost()) {
            // Sécurité

            $this->secure();

            // Suppression

            $deleted = $this->userModel->delete($id);

            if ($deleted) {
                Session::success("L'utilisateur a bien été supprimé.");
            } else {
                Session::error();
            }

            Redirection::to("/users");

            return;
        }

        // Rendu

        $this->render("users/delete_user.twig", [
            "session" => Session::all(),

            "pageTitle" => "Suppression de l'utilisateur $username",

            "id" => $id,
            "username" => $username,

            "nbThemes" => $nbThemes,
            "nbExpressions" => $nbExpressions
        ]);
    }

    /**
     * Demande de nouveau mot de passe
     */

    public function reset() {
        // Connexion

        // Rendu

        $this->render("users/reset.twig", [
            "pageTitle" => "Réinitialisation du mot de passe"
        ]);
    }

    /**
     * Confirmation du nouveau mot de passe
     */

    public function confirm() {
        // Connexion

        // Rendu

        $this->render("users/confirm.twig", [
            "pageTitle" => "Confirmation du changement de mot de passe"
        ]);
    }
}