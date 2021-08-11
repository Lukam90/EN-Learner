<?php

namespace app\controllers;

use app\core\Session;

use app\models\Theme;
use app\models\User;

use app\controllers\Controller;

class ThemesController extends Controller {
    private $themeModel;
    private $userModel;

    // Constructeur

    public function __construct() {
        $this->init();

        $this->themeModel = new Theme();
        $this->userModel = new User();
    }

    // Liste des thèmes

    public function index() {
        // Données

        $list = $this->themeModel->findAll();

        $themes = [];

        $index = 0;

        // Ajout

        $canAdd = false;

        $userId = 0;

        if (Session::isLoggedIn()) {
            $userId = Session::var("user_id");

            $canAdd = ! $currentUser.banned;
        }

        // Boucle d'affichage

        foreach ($list as $theme) {
            // Lecture

            $themeId = $theme->id;
            $title = $theme->title;
            $author = $this->themeModel->findUser($themeId);
            $nbExpressions = $this->themeModel->countExpressions($themeId);

            // Edition

            $belongsTo = $this->themeModel->belongsTo($userId, $themeId);
            $isSuperUser = $this->userModel->isSuperUser($userId);

            $canEdit = $canAdd && $belongsTo && $isSuperUser;

            // Enregistrement

            $themes[$index]["id"] = $themeId;
            $themes[$index]["title"] = $title;
            $themes[$index]["author"] = $author;
            $themes[$index]["nbExpressions"] = $nbExpressions;
            $themes[$index]["canEdit"] = $canEdit;

            $index++;
        }

        // Rendu

        echo $this->twig->render("themes.twig", [
            "themes" => $themes,
            "can-add" => $canAdd,
            "can-edit" => $canEdit
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