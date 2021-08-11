<?php

namespace app\core;

abstract class Request {
    public static function is($method) {
        return $_SERVER["REQUEST_METHOD"] == $method;
    }

    public static function isGet() {
        return self::is("GET");
    }

    public static function isPost() {
        return self::is("POST");
    }
}