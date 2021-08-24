<?php

namespace app\core;

/**
 * Fake test data class
 */

abstract class Faker {
    /**
     * Load fake CSV data
     */

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

    /**
     * Generate alphanumeric basic characters
     */

    public static function alphabet() {
        $alphabet = "0123456789";
        $alphabet .= "abcdefghijklmnopqrstuvwxyz";
        $alphabet .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        return $alphabet;
    }

    /**
     * Generate random string
     */

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

    /**
     * Generate random email
     */

    public static function email() {
        return self::string() . "@fakemail.com";
    }

    /**
     * Generate random role
     */

    public static function role () {
        $number = rand(0, 2);

        $roles = ["Membre", "Modérateur", "Administrateur"];

        return $roles[$number];
    }
}