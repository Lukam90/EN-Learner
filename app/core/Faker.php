<?php

namespace app\core;

abstract class Faker {
    // Chargement de données de tests (CSV)

    public static function loadCSV($tableName, $attributes) {
        $length = 0;
        $data = [];

        $file = fopen("$tableName.csv", "r");
        
        while(! feof($file)) {
            $line = Security::clean(fgets($file));
            
            $values = explode(";", $line);

            $index = 0;

            foreach ($attributes as $key) {
                $value = $values[$index];

                $data[$length][$key] = $value;

                $index++;
            }

            $length++;
        }
        
        fclose($file);
        
        return $data;
    }

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