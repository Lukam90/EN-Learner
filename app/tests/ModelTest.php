<?php

namespace app\tests;

use PHPUnit\Framework\TestCase;

abstract class ModelTest extends TestCase {
    protected $className;

    // Ecriture dans le fichier log

    public function log($name, $var) {
        $file = fopen("app/tests/testlog.txt", "a") or die("Unable to open the log file.");

        fwrite($file, "\n" . __CLASS__ . "$name : $var\n");

        fclose($file);
    }

    // Suppression du contenu du fichier log

    public function erase() {
        $file = fopen("app/tests/testlog.txt", "w") or die("Unable to open the log file.");

        fwrite($file, "");

        fclose($file);
    }

    /*
    // Log d'une fonction avec des données

    public function print($name, $var) {
        echo "\n$name : $var\n";
    }

    // Appels de fonctions

    public function call($methodName, $a = null, $b = null, $c = null) {
        $data = $this->model->$methodName($a, $b, $c);

        $this->print($methodName, $data);
    }
    */
}