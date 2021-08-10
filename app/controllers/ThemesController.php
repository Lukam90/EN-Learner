<?php

namespace app\controllers;

use app\controllers\Controller;

use app\models\Theme;

class ThemesController extends Controller {
    private $themeModel;

    // Constructeur

    public function __construct() {
        $this->init();

        $this->themeModel = new Theme();
    }

    // Liste des thèmes

    public function index() {
        // 

        // Rendu

        echo $this->twig->render("themes.twig", [
            "key" => "value",
        ]);
    }

    // Liste des expressions d'un thème

    public function show($id) {
        // 

        // Rendu

        echo $this->twig->render("themes/show_theme.twig", [
            "title" => "Une liste de vocabulaire",
        ]);
    }

    // Ajout d'un nouveau thème

    public function new() {
        // titre, user_id

        // Rendu

        echo $this->twig->render("themes/new_theme.twig", [
            "key" => "value",
        ]);
    }

    // Edition d'un thème (titre)

    public function edit($id) {
        // 

        // Rendu

        echo $this->twig->render("themes/edit_theme.twig", [
            "title" => "Mon thème",
        ]);
    }

    // Suppression d'un thème (titre)

    public function delete($id) {
        // 

        // Rendu

        echo $this->twig->render("themes/delete_theme.twig", [
            "title" => "Mon thème",
        ]);
    }

    // Jeu de flashcards

    public function start($id) {
        // 

        // Rendu

        echo $this->twig->render("themes/game.twig", [
            "title" => "Mon thème",
        ]);
    }
}