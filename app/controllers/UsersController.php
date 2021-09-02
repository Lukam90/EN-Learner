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

    /* Utilisateurs */

    // Ensemble des utilisateurs

    public function getAllUsers() {
        return $this->userModel->findAll();
    }

    // Sélection d'un utilisateur par l'ID

    public function getUserById($userId) {
        return $this->userModel->findOneById($userId);
    }

    // Sélection d'un utilisateur par l'e-mail

    public function getUserByEmail($email) {
        return $this->userModel->findOneByEmail($email);
    }

    // Utilisateur existant

    public function exists($userId) {
        $exists = $this->getUserById($userId);

        if (! $exists) {
            self::alert("L'utilisateur n'existe pas.");

            Redirection::to("/users");

            return;
        }
    }

    // Couleur / Rôle

    public function setColor($role) {
        $color = "black";

        if ($role == "Administrateur") {
            $color = "red";
        } else if ($role == "Modérateur") {
            $color = "green";
        }

        return $color;
    }

    // Utilisateur non suspendu

    public function notSuspended($email) {
        $user = $this->getUserByEmail($email);

        $isSuspended = ($user["role"] === "Suspendu");

        if ($isSuspended) {
            Session::alert("Votre compte a été suspendu. Vous n'êtes pas autorisé(e) à vous connecter.");

            Redirection::to("/");

            return;
        }
    }

    // Connexion d'un utilisateur

    public function canLogIn($email, $password) {
        $isLoggedIn = $this->userModel->login($email, $password);

        if ($isLoggedIn) {
            $errors = $this->getErrors();

            $errors["login"] = "";

            // Utilisateur trouvé

            $user = $this->getUserByEmail($email);

            // Utilisateur autorisé

            $this->notSuspended($email);

            Session::login($user);

            Session::success("Vous êtes connecté(e).");

            Redirection::to("/");

            return;
        } else {
            $errors["login"] = "Les identifiants sont incorrects. Veuillez réessayer.";
        }
    }

    // Même utilisateur

    public function sameUser($userId) {
        $currentUserId = Session::get("user_id");

        return $currentUserId == $userId;
    }

    // Utilisateur autorisé

    public function isAuthorized($userId) {
        return $this->isSuperUser() || $this->sameUser($userId);
    }

    // Accès à la page de profil

    public function canAccess($userId) {
        if (! $this->sameUser($userId)) {
            Session::alert("Vous n'êtes pas autorisé(e) à accéder à cette page de profil utilisateur.");

            Redirection::to("/");

            return;
        }
    }

    /* CRUD */

    // Ajout d'un nouvel utilisateur

    public function insertUser($values) {
        $newUser = [
            "username" => $values["username"],
            "email" => $values["email"],
            "password" => $values["password"],

            "role" => "Membre"
        ];

        $registered = $this->userModel->insert($newUser);

        if ($registered) {
            Session::success("Votre inscription a été prise en compte avec succès. Bienvenue sur notre site, cher nouveau membre !");

            Redirection::to("/users/login");

            return;
        } else {
            Session::error();
        }
    }

    // Changement de rôle / statut

    public function changeRole($userId, $role) {
        $saved = $this->userModel->changeRole($userId, $role);

        if ($saved) {
            Session::success("Le rôle de l'utilisateur a bien été édité.");
        } else {
            Session::error();
        }

        Redirection::to("/users");

        return;
    }

    // Suppression d'un utilisateur

    public function deleteUser($themeId) {
        $deleted = $this->userModel->delete($themeId);

        if ($deleted) {
            Session::success("L'utilisateur a bien été supprimé.");
        } else {
            Session::error();
        }

        Redirection::to("/users");

        return;
    }

    /* Thèmes */

    // Nombre de thèmes

    public function getNbThemes($userId) {
        return $this->userModel->countThemes($userId);
    }

    // L'utilisateur est l'auteur du thème

    public function ownsTheme($themeId) {
        $userId = Session::get("user_id");

        $this->themeModel->belongsTo($userId, $themeId);
    }

    /* Expressions */

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

    // Formulaire d'inscription

    public function validateRegisterForm() {
        $errors = $this->getErrors();

        return empty($errors["username"]) &&
               empty($errors["email"]) &&
               empty($errors["password"]) &&
               empty($errors["confirm"]);
    }

    // Formulaire de connexion

    public function validateLoginForm($email, $password) {
        $isEmpty = empty($email) || empty($password);

        if ($isEmpty) {
            Session::alert("Les champs doivent être renseignés.");

            Redirection::to("/users/login");

            return;
        }
    }

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

            $userId = $user["id"];

            $username = $user["username"];
            $role = $user["role"];

            $createdAt = new \DateTime($user["created_at"]);
            $createdAt = $createdAt->format("d/m/Y");

            $nbThemes = $this->getNbThemes($userId);
            $nbExpressions = $this->getNbExpressions($userId);

            // Couleur / Rôle

            $color = $this->setColor($role);

            // Edition

            $canEdit = $this->isSuperUser() || $this->ownsTheme($themeId);

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

    public function profile($userId) {
        Session::start();

        // Utilisateur connecté

        $this->isLoggedIn();

        // Utilisateur autorisé

        $this->canAccess($userId);

        // Utilisateur sélectionné

        $user = $this->getUserById($userId);

        $username = $user["username"];
        $email = $user["email"];
        $oldPassword = $user["password"];

        // Stats

        $nbThemes = $this->getNbThemes($userId);
        $nbExpressions = $this->getNbExpressions($userId);

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

            $username = $this->getCheckedUsername();
            $email = $this->getCheckedEmail();
            $password = $this->getCheckedPassword();
            $confirm = $this->getCheckedConfirm($password);

            // Validation

            $errors = $this->getErrors();

            $valid = $this->validateRegisterForm();

            // Enregistrement

            if ($valid) {
                $values = [
                    "username" => $username,
                    "email" => $email,
                    "password" => $password
                ];

                $this->insertUser($values);
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

        // Invité / Utilisateur non connecté

        $this->isGuest();

        // Données du formulaire

        $email = "";
        $password = "";

        // Envoi du formulaire

        $errors = [];

        if (Request::isPost()) {
            // Données

            sleep(1);

            $email = Post::var("email");
            $password = Post::var("password");

            // Champs renseignés

            $this->validateLoginForm($email, $password);

            // Connexion d'un utilisateur

            $this->canLogIn($email, $password);
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

    public function edit($userId) {
        Session::start();

        // Utilisateur connecté

        $this->isLoggedIn();

        // Utilisateur existant

        $this->exists($userId);

        // Utilisateur autorisé

        $this->isAuthorized($userId);

        // Utilisateur sélectionné

        $user = $this->getUserById($userId);

        $id = $user["id"];
        $username = $user["username"];
        $role = $user["role"];

        // Envoi des données

        if (Request::isPost()) {
            // Sécurité

            $this->secure();

            // Edition

            $role = Post::var("role");

            $this->changeRole($userId, $role);
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

        // Utilisateur connecté

        $this->isLoggedIn();

        // Utilisateur existant

        $this->exists($userId);

        // Utilisateur autorisé

        $this->isAuthorized($userId);

        // Utilisateur sélectionné

        $user = $this->getUserById($userId);

        $username = $user["username"];

        $nbThemes = $this->getNbThemes($userId);
        $nbExpressions = $this->getNbExpressions($userId);

        // Envoi des données

        if (Request::isPost()) {
            // Sécurité

            $this->secure();

            // Suppression

            $this->deleteUser($userId);
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