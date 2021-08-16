<?php

namespace app\core;

use app\core\Security;

abstract class Cookie {
    // Récupération d'un cookie

    public static function get($parameter) {
        if (self::has($parameter)) {
            return Security::clean($_COOKIE[$parameter]);
        }
    }

    // Existence d'un cookie

    public static function has($parameter) {
        return isset($_COOKIE[$parameter]);
    }
}