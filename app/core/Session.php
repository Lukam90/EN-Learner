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
     * Error if not matching token
     */

    public static function expiredToken() {
        if (Post::var("token") != self::get("token")) {
            self::alert("Le token CSRF a expiré. Veuillez vous reconnecter.");

            Redirection::to("/users/logout");

            return;
        }
    }

    /**
     * Session log in
     */

    public static function login($user) {
        self::setToken();

        self::set("user_id", $user["id"]);
        self::set("username", $user["username"]);
        self::set("email", $user["email"]);
    }

    /**
     * Session log out
     */

    public static function logout() {
        self::delete("user_id");
        self::delete("token");
    }
}