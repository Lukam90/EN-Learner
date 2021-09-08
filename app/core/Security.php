<?php

namespace app\core;

abstract class Security {
    // Nettoyage des caractères spéciaux (XSS)

    public static function clean($string) {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);

        return $string;
    }

    // Cryptage des mots de passe

    public static function hash($string) {
        return password_hash($string, PASSWORD_BCRYPT);
    }

    // Correspondance du jeton CSRF

    public static function checkCSRF() {
        return $_POST["token"] == $_SESSION["token"];
    }
}