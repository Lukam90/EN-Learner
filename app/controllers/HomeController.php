<?php

namespace app\controllers;

use app\controllers\Controller;

use app\models\User;
use app\models\Theme;
use app\models\Expression;

class HomeController extends Controller {
    private $userModel;
    private $themeModel;
    private $expressionModel;

    // Constructeur

    public function __construct() {
        $this->init();

        $this->userModel = new User();
        $this->themeModel = new Theme();
        $this->expressionModel = new Expression();
    }

    // Page d'accueil

    public function index() {
        // Stats

        $nbUsers = $this->userModel->count();
        $nbThemes = $this->themeModel->count();
        $nbExpressions = $this->expressionModel->count();

        // Rendu

        echo $this->twig->render("home.twig", [
            "title"         => "Accueil",
            "nbUsers"       => $nbUsers,
            "nbThemes"      => $nbThemes,
            "nbExpressions" => $nbExpressions
        ]);
    }
}