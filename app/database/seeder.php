<?php

use app\core\Database;

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

/* Table des utilisateurs */

// Création

$userModel->create();

// Données

$users = $userModel->loadCSV(["username", "email", "password", "role"]);

foreach ($users as $user) {
    $userModel->insert($user);
}

/* Table des thèmes */

// Création

$themeModel->create();

// Données

$themes = $themeModel->loadCSV(["title", "user_id"]);
        
foreach ($themes as $theme) {
    $themeModel->insert($theme);
}

/* Table des expressions */

// Création

$expressionModel->create();

// Données

$expressions = $expressionModel->loadCSV(["french", "english", "phonetics", "theme_id", "user_id"]);

foreach ($expressions as $expression) {
    $expressionModel->insert($expression);
}

// Message de confirmation

echo "Base de données EN-Learner générée.\n";