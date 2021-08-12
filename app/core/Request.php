<?php

namespace app\core;

abstract class Request {
    // Même page

    public static function self() {
        return $_SERVER['PHP_SELF'];
    }

    // Méthode d'envoi

    public static function is($method) {
        return $_SERVER["REQUEST_METHOD"] == $method;
    }

    // Méthode GET

    public static function isGet() {
        return self::is("GET");
    }

    // Méthode POST

    public static function isPost() {
        return self::is("POST");
    }
}