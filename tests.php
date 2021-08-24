<?php

use app\core\Faker;
use app\core\Security;

use app\tests\UserTest;
use app\tests\ThemeTest;
use app\tests\ExpressionTest;

require "vendor/autoload.php";

// Classes des tests des modèles

$userTest = new UserTest();
$userTest->erase();
//$userTest->launch();

$themeTest = new ThemeTest();
//$themeTest->launch();

$expressionTest = new ExpressionTest();
$expressionTest->launch();

echo "Log - UserTest\n";