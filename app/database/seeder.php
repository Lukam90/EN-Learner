<?php

use app\core\Faker;

use app\models\User;
use app\models\Theme;
use app\models\Expression;

$root = dirname(dirname(__DIR__));

require $root . "/vendor/autoload.php";

// Modèles -> Tables

$userModel = new User();
$themeModel = new Theme();
$expressionModel = new Expression();

// Suppression des tables

$expressionModel->drop();
$themeModel->drop();
$userModel->drop();

/* Utilisateurs */

// Création

$userModel->create();

// Données

$users = Faker::loadCSV("users", ["username", "email", "password", "role"]);

foreach ($users as $user) {
    $userModel->insert($user);
}

/* Thèmes */

// Création

$themeModel->create();

// Données

$themes = Faker::loadCSV("themes", ["title", "user_id"]);
        
foreach ($themes as $theme) {
    $themeModel->insert($theme);
}

/* Expressions */

// Création

$expressionModel->create();

// Données

$expressions = Faker::loadCSV("expressions", ["french", "english", "phonetics", "theme_id", "user_id"]);

foreach ($expressions as $expression) {
    $expressionModel->insert($expression);
}

// Message de confirmation

echo "Base de données EN-Learner générée.\n";