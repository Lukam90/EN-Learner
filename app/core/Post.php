<?php

namespace app\core;

use app\core\Security;

abstract class Post {
    public static function var($parameter) {
        if (self::has($parameter)) {
            return Security::clean($_POST[$parameter]);
        }
    }

    public static function has($parameter) {
        return isset($_POST[$parameter]);
    }

    public static function empty($parameter) {
        return empty(self::var($parameter));
    }
}