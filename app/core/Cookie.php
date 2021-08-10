<?php

namespace app\core;

abstract class Cookie {
    static function var($parameter) {
        if (self::has($parameter)) {
            return $_COOKIE[$parameter];
        }
    }

    static function has($parameter) {
        return isset($_COOKIE[$parameter]);
    }
}