<?php

namespace app\core;

use app\core\Security;

abstract class Post {
    // Contenu d'une variable POST

    public static function var($parameter) {
        if (self::has($parameter)) {
            return Security::clean($_POST[$parameter]);
        }
    }

    // Variable POST existante

    public static function has($parameter) {
        return isset($_POST[$parameter]);
    }

    // Variable POST vide

    public static function empty($parameter) {
        return empty(self::var($parameter));
    }

    // Existence d'un objet POST 

    public static function exists() {
        return isset($_POST);
    }
}