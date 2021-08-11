<?php

namespace app\core;

use app\core\Security;

abstract class Get {
    public static function var($parameter) {
        if (self::has($parameter)) {
            return Security::clean($_GET[$parameter]);
        }
    }

    public static function has($parameter) {
        return isset($_GET[$parameter]);
    }
}