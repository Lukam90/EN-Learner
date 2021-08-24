<?php

namespace app\core;

use app\core\Security;
use app\core\Redirection;

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

    public static function redirectWith($type, $message) {
        self::set($type, $message);

        Redirection::home();

        self::erase();

        exit;
    }

    /**
     * Error if logged in
     */

    public static function errorIfLoggedIn() {
        if (self::isLoggedIn()) {
            self::redirectWith("alert", "Vous êtes déjà connecté(e).");
        }
    }

    /**
     * Error if not logged in
     */

    public static function errorIfNotLoggedIn() {
        if (! self::isLoggedIn()) {
            self::redirectWith("alert", "Vous devez être connecté(e) pour accéder à cette page.");
        }
    }

    /**
     * Redirect if logged in
     */

    public static function redirectIfLoggedIn() {
        if (self::isLoggedIn()) {
            self::redirectWith("success", "Vous êtes connecté(e).");
        }
    }

    /**
     * Error if banned
     */
    public static function errorIfBanned() {
        self::redirectWith("alert", "Votre compte a été suspendu. Vous n'êtes pas autorisé(e) à vous connecter.");
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