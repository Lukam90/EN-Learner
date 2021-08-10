<?php

namespace app\core;

abstract class Get {
    public static function var($parameter) {
        if (self::has($parameter)) {
            return $_GET[$parameter];
        }
    }

    public static function has($parameter) {
        return isset($_GET[$parameter]);
    }
}