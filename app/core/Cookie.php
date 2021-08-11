<?php

namespace app\core;

use app\core\Security;

abstract class Cookie {
    static function var($parameter) {
        if (self::has($parameter)) {
            return Security::clean($_COOKIE[$parameter]);
        }
    }

    static function has($parameter) {
        return isset($_COOKIE[$parameter]);
    }
}