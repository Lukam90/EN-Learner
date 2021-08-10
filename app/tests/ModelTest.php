<?php

namespace app\tests;

abstract class ModelTest {
    protected $model;

    // Ecriture dans le fichier log

    public function log($content) {
        $file = fopen("app/tests/testlog.txt", "a") or die("Unable to open the log file.");

        fwrite($file, $content . "\n\n");

        fclose($file);
    }

    // Suppression du contenu du fichier log

    public function erase() {
        $file = fopen("app/tests/testlog.txt", "w") or die("Unable to open the log file.");

        fwrite($file, "");

        fclose($file);
    }

    // Log d'une fonction avec des données

    public function print($methodName, $data) {
        $str = print_r($data, true);

        $this->log($methodName);
        $this->log($str);
    }

    // Appels de fonctions

    public function call($methodName, $a = null, $b = null, $c = null) {
        $data = $this->model->$methodName($a, $b, $c);

        $this->print($methodName, $data);
    }
}