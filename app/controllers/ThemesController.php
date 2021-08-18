<?php

namespace app\controllers;

use app\models\User;

use app\core\Request;
use app\core\Session;

use app\models\Theme;

use app\controllers\Controller;
use app\validation\ThemeValidation;

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

            $themes[] = [
                "id" => $themeId,
                "title" => $title,
                "author" => $author,
                "nbExpressions" => $nbExpressions,
                "canEdit" => $canEdit
            ];
        }

        // Rendu

        echo $this->twig->render("themes.twig", [
            "session" => Session::all(),

            "themes" => $themes,
            "can-add" => $canAdd,
            "can-edit" => $canEdit
        ]);
    }

    // Liste des expressions d'un thème

    public function show($themeId) {
        // Données

        $theme = $this->themeModel->findById($themeId);

        $title = $theme->title;

        $list = $this->themeModel->findExpressions($themeId);

        $expressions = [];

        $canAdd = true;

        // Boucle d'affichage

        foreach ($list as $expression) {
            // Lecture

            $id = $expression->id;
            $french = $expression->french;
            $english = $expression->english;
            $phonetics = $expression->phonetics;

            $author = $this->themeModel->findUser($themeId);

            $userId = $expression->user_id;
            $belongsTo = $this->themeModel->belongsTo($userId, $themeId);
            $isSuperUser = $this->userModel->isSuperUser($userId);

            $canEdit = $belongsTo || $isSuperUser;

            // Enregistrement

            $expressions[] = [
                "id" => $id,
                "french" => $french,
                "english" => $english,
                "phonetics" => $phonetics,
                "author" => $author,
                "canEdit" => true,
            ];
        }

        // Rendu

        echo $this->twig->render("themes/show_theme.twig", [
            "session" => Session::all(),

            "title" => $title,
            "expressions" => $expressions,
            "canAdd" => $canAdd
        ]);
    }

    // Ajout d'un nouveau thème

    public function new() {
        // titre, user_id

        // Validation

        $validator = new ThemeValidation();

        // Indication

        $validator->setTip("title", "Le titre doit être renseigné et contenir jusqu'à 50 caractères.");

        // Titre

        $title = "";

        // Envoi du formulaire

        $errors = [];

        if (Request::isPost()) {
            //sleep(1);

            var_dump($_POST);

            $title = $validator->title();

            // Validation

            $errors = $validator->getErrors();

            $valid = ! empty($errors); // && ! $loggedIn;

            var_dump($errors);

            // Enregistrement

            if ($valid) {
                $newTheme = [
                    "title" => $title,
                    "user_id" => 1,
                ];

                $saved = $this->themeModel->insert($newTheme);

                if ($saved) {
                    Session::success("Le thème a bien été ajouté.");

                    header("Location : ./themes");
                } else {
                    Session::error();
                }
            }
        }

        // Rendu

        echo $this->twig->render("themes/new_theme.twig", [
            "session" => Session::all(),

            "tips" => $validator->getTips(),
            "errors" => $validator->getErrors(),
            "loggedIn" => true,

            "title" => $title,
        ]);
    }

    // Edition d'un thème (titre)

    public function edit($id) {
        // 

        // Rendu

        echo $this->twig->render("themes/edit_theme.twig", [
            "session" => Session::all(),

            "title" => "Mon thème",
        ]);
    }

    // Suppression d'un thème (titre)

    public function delete($id) {
        // 

        // Rendu

        echo $this->twig->render("themes/delete_theme.twig", [
            "session" => Session::all(),
            
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