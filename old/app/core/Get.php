<?php

namespace app\core;

use app\core\Security;

abstract class Get {
    // Contenu d'une variable GET 

    public static function var($parameter) {
        if (self::has($parameter)) {
            return Security::clean($_GET[$parameter]);
        }
    }

    // Existence d'une variable GET 

    public static function has($parameter) {
        return isset($_GET[$parameter]);
    }

    // Existence d'un objet GET 

    public static function exists() {
        return isset($_GET);
    }
}