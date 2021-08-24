<?php

namespace app\core;

use app\core\Security;

/**
 * $_COOKIE Class
 */

abstract class Cookie {
    /**
     * Get a cookie
     */

    public static function get($parameter) {
        if (self::has($parameter)) {
            return Security::clean($_COOKIE[$parameter]);
        }
    }

    /**
     * Check if a cookie exists 
     */

    public static function has($parameter) {
        return isset($_COOKIE[$parameter]);
    }
}