<?php

namespace app\core;

use app\core\Security;

/**
 * $_GET Class
 */

abstract class Get {
    /**
     * $_GET variable's content
     */ 

    public static function var($parameter) {
        if (self::has($parameter)) {
            return Security::clean($_GET[$parameter]);
        }
    }

    /**
     * Check if a $_GET variable exists
     */

    public static function has($parameter) {
        return isset($_GET[$parameter]);
    }

    /**
     * Check if $_GET exists
     */

    public static function exists() {
        return isset($_GET);
    }
}