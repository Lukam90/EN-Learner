<?php

namespace app\core;

use app\core\Security;

class Session {
    // Démarrage d'une session

    public static function start() {
        if (! self::exists()) {
            session_start();
        }
    }

    // Existence d'une session

    public static function exists() {
        return isset($_SESSION);
    }

    // Enregistrement d'une session

    public static function set($name, $variable) {
        self::start();

        $_SESSION[$name] = Security::clean($variable);
    }

    // Variable de session

    public static function get($parameter) {
        if (self::has($parameter)) {
            return $_SESSION[$parameter];
        }
    }

    // Existence d'une variable

    public static function has($parameter) {
        return isset($_SESSION[$parameter]);
    }

    // Suppression d'une variable

    public static function delete($parameter) {
        unset($_SESSION[$parameter]);
    }

    // Messages Flash

    // Succès

    public static function success($message) {
        self::set("success", $message);
    }

    // Erreur

    public static function alert($message) {
        self::set("alert", $message);
    }

    // Utilisateur connecté (ID)

    public static function isLoggedIn() {
        return self::has("user_id");
    }
}