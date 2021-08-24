<?php

namespace app\core;

use app\core\Security;

/**
 * $_POST Class
 */

abstract class Post {
    /**
     * $_POST variable's content
     */

    public static function var($parameter) {
        if (self::has($parameter)) {
            return Security::clean($_POST[$parameter]);
        }
    }

    /**
     * Check if a $_POST variable exists
     */

    public static function has($parameter) {
        return isset($_POST[$parameter]);
    }

    /**
     * Check if a $_POST variable is empty
     */

    public static function empty($parameter) {
        return empty(self::var($parameter));
    }

    /**
     * Check if $_POST exists
     */

    public static function exists() {
        return isset($_POST);
    }
}