<?php

namespace app\core;

/**
 * Requests Class
 */

abstract class Request {
    /**
     * Same page
     */

    public static function self() {
        return $_SERVER['PHP_SELF'];
    }

    /**
     * Check sending method (GET, POST)
     */

    public static function is($method) {
        return $_SERVER["REQUEST_METHOD"] == $method;
    }

    /**
     * Check if GET method
     */

    public static function isGet() {
        return self::is("GET");
    }

    /**
     * Check if POST method
     */

    public static function isPost() {
        return self::is("POST");
    }
}