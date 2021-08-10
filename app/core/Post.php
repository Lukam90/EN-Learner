<?php

namespace app\core;

abstract class Post {
    public static function var($parameter) {
        if (self::has($parameter)) {
            return $_POST[$parameter];
        }
    }

    public static function has($parameter) {
        return isset($_POST[$parameter]);
    }
}