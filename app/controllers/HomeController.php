<?php

namespace app\controllers;

use app\core\Session;

use app\models\User;
use app\models\Theme;
use app\models\Expression;

use app\controllers\Controller;

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
        Session::start();

        // Stats

        $nbUsers = $this->userModel->count();
        $nbThemes = $this->themeModel->count();
        $nbExpressions = $this->expressionModel->count();

        // Rendu

        echo $this->twig->render("home.twig", [
            "session" => Session::all(),
            
            "title"         => "Accueil",
            "nbUsers"       => $nbUsers,
            "nbThemes"      => $nbThemes,
            "nbExpressions" => $nbExpressions
        ]);

        Session::erase();
    }
}