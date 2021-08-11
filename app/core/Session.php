<?php

namespace app\core;

use app\core\Security;

class Session {
    public static function var($parameter) {
        if (self::has($parameter)) {
            return Security::clean($_SESSION[$parameter]);
        }
    }

    public static function has($parameter) {
        return isset($_SESSION[$parameter]);
    }

    public static function start() {
        session_start();
    }

    public static function delete($parameter) {
        unset($_SESSION[$parameter]);
    }

    public static function isLoggedIn() {
        return self::has("user_id");
    }    
}