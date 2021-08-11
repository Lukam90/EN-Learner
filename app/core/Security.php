<?php

namespace app\core;

abstract class Security {
    public static function clean($string) {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);

        return $string;
    }

    public static function hash($string) {
        return password_hash($string, PASSWORD_BCRYPT);
    }
}