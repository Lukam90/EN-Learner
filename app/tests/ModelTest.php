<?php

namespace app\tests;

use PHPUnit\Framework\TestCase;

abstract class ModelTest extends TestCase {
    // Test d'initialisation

    public function testInit() {
        $res = $this->erase();

        $this->assertEmpty($res);
    }

    // Ecriture dans le fichier log

    public function log($className, $methodName, $var) {
        $file = fopen("app/tests/testlog.txt", "a") or die("Unable to open the log file.");

        fwrite($file, "\n$className - $methodName = $var\n");

        fclose($file);
    }

    // Suppression du contenu du fichier log

    public function erase() {
        $file = fopen("app/tests/testlog.txt", "w") or die("Unable to open the log file.");

        fwrite($file, "");

        fclose($file);
    }
}