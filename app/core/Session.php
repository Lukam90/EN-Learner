<?php

namespace app\core;

use app\core\Post;
use app\core\Security;
use app\core\Redirection;

use app\models\User;
use app\models\Theme;
use app\models\Expression;

class Session {
    /**
     * Start a session
     */

    public static function start() {
        if (! self::exists()) {
            session_start();
        }
    }

    /**
     * Check if $_SESSION exists
     */

    public static function exists() {
        return isset($_SESSION);
    }

    /**
     * Set a $_SESSION variable
     */

    public static function set($name, $variable) {
        self::start();

        $_SESSION[$name] = Security::clean($variable);
    }

    /**
     * Generate a CSRF token
     */

    public static function setToken() {
        self::start();

        $_SESSION["token"] = bin2hex(random_bytes(50));
    }

    /**
     * Get $_SESSION variable
     */

    public static function get($parameter) {
        if (self::has($parameter)) {
            return $_SESSION[$parameter];
        }
    }

    /**
     * Check if a $_SESSION variable exists
     */

    public static function has($parameter) {
        return isset($_SESSION[$parameter]);
    }

    /**
     * Delete a _SESSION variable
     */

    public static function delete($parameter) {
        unset($_SESSION[$parameter]);
    }

    /**
     * Get the whole $_SESSION variables
     */

    public static function all() {
        if (self::exists()) {
            return $_SESSION;
        }
    }

    /* Flash Messages */

    /**
     * Define a success message
     */

    public static function success($message) {
        self::set("success", $message);
    }

    /**
     * Define an error message
     */

    public static function alert($message) {
        self::set("alert", $message);
    }

    /**
     * Get a general error message
     */

    public static function error() {
        self::alert("Une erreur s'est produite. Veuillez contacter l'administrateur du site.");
    }

    /**
     * Erase messages
     */

    public static function erase() {
        self::delete("success");
        self::delete("alert");
    }

    /* Login */

    /**
     * Connected used with ID
     */

    public static function isLoggedIn() {
        return self::has("user_id");
    }

    /**
     * Redirect with message
     */

    public static function redirectHomeWith($type, $message) {
        self::set($type, $message);

        header("Location: http://localhost/en_app");

        exit;
    }

    /**
     * Logout with message
     */

    public static function logoutWith($type, $message) {
        self::set($type, $message);

        header("Location: http://localhost/en_app/users/logout");

        exit;
    }

    /**
     * Error if logged in
     */

    public static function errorIfLoggedIn() {
        if (self::isLoggedIn()) {
            self::redirectHomeWith("alert", "Vous êtes déjà connecté(e).");
        }
    }

    /**
     * Error if not logged in
     */

    public static function errorIfNotLoggedIn() {
        if (! self::isLoggedIn()) {
            self::redirectHomeWith("alert", "Vous devez être connecté(e) pour accéder à cette page.");
        }
    }

    /**
     * Error if not authorized
     */

    public static function errorIfNotAuthorized($isMethod) {
        self::errorIfNotLoggedIn();

        $userId = self::get("user_id");

        $userModel = new User();

        $isAuthorized = $userModel->$isMethod($userId);

        if (! $isAuthorized) {
            self::redirectHomeWith("alert", "Vous n'êtes pas autorisé(e) à effectuer cette action.");
        }
    }

    /**
     * Error if not superuser (moderator or admin)
     */

    public static function errorIfNotSuperUser() {
        self::errorIfNotAuthorized("isSuperUser");
    }

    /**
     * Error if not admin
     */

    public static function errorIfNotAdmin() {
        self::errorIfNotAuthorized("isAdmin");
    }

    /**
     * Error if banned
     */
    
    public static function errorIfBanned() {
        self::redirectHomeWith("alert", "Votre compte a été suspendu. Vous n'êtes pas autorisé(e) à vous connecter.");
    }

     /**
     * Error if not matching token
     */

    public static function errorIfNotToken() {
        if (Post::var("token") != self::get("token")) {
            self::logoutWith("alert", "Le token CSRF a expiré. Veuillez vous reconnecter.");
        }
    }

    /**
     * Error if user not exists
     */
    
    public static function errorIfUserNotExists($userId) {
        $userModel = new User();

        $exists = $userModel->findOneById($userId);

        if (! $exists) {
            self::alert("L'utilisateur n'existe pas.");

            header("Location: http://localhost/en_app/users");

            return;
        }
    }

    /**
     * Error if theme not exists
     */
    
    public static function errorIfThemeNotExists($themeId) {
        $themeModel = new Theme();

        $exists = $themeModel->findOneById($themeId);

        if (! $exists) {
            self::alert("Le thème n'existe pas.");

            header("Location: http://localhost/en_app/themes");

            return;
        }
    }

    /**
     * Error if expression not exists
     */
    
    public static function errorIfExpressionNotExists($expressionId) {
        $expressionModel = new Expression();
    
        $exists = $expressionModel->findOneById($expressionId);
    
        if (! $exists) {
            self::alert("L'expression n'existe pas.");
    
            header("Location: http://localhost/en_app/expressions");
    
            return;
        }
    }

    /**
     * Redirect if logged in
     */

    public static function redirectIfLoggedIn() {
        if (self::isLoggedIn()) {
            self::redirectHomeWith("success", "Vous êtes connecté(e).");
        }
    }

    /**
     * Session log in
     */

    public static function login($user) {
        self::setToken();

        self::set("user_id", $user->id);
        self::set("username", $user->username);
        self::set("email", $user->email);
    }

    /**
     * Session log out
     */

    public static function logout() {
        self::delete("user_id");
        self::delete("token");
    }
}