<?php

namespace app\core;

use app\core\Post;
use app\core\Session;

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

    public static function expiredToken() {
        if (Post::var("token") != Session::get("token")) {
            Session::alert("Le token CSRF a expiré. Veuillez vous reconnecter.");

            Redirection::to("/users/logout");

            exit;
        }
    }
}