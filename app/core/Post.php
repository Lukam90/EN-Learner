<?php

namespace app\core;

abstract class Post {
    public static function var($parameter) {
        if (self::has($parameter)) {
            return $_POST[$parameter];
        }
    }

    public static function hash($parameter) {
        return password_hash(self::var($parameter, PASSWORD_BCRYPT));
    }

    public static function has($parameter) {
        return isset($_POST[$parameter]);
    }

    public static function empty($parameter) {
        return empty(self::var($parameter));
    }
}