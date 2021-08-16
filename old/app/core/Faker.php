<?php

namespace app\core;

abstract class Faker {
    public static function alphabet() {
        $alphabet = "0123456789";
        $alphabet .= "abcdefghijklmnopqrstuvwxyz";
        $alphabet .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        return $alphabet;
    }

    public static function string($length = 20) {
        $alphabet = self::alphabet();

        $nbCars = strlen($alphabet) - 1;

        $result = "";

        for ($i = 0 ; $i < $length ; $i++) {
            $index = rand(0, $nbCars);

            $result .= $alphabet[$index];
        }

        return $result;
    }

    public static function password() {
        return password_hash(self::string(), PASSWORD_BCRYPT);
    }

    public static function email() {
        return self::string() . "@fakemail.com";
    }

    public static function role () {
        $number = rand(0, 2);

        $roles = ["Membre", "Modérateur", "Administrateur"];

        return $roles[$number];
    }
}