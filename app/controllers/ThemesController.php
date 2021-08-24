<?php

namespace app\controllers;

use app\core\Redirection;
use app\core\Request;
use app\core\Session;
use app\core\Security;

use app\models\User;
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
        Session::start();

        /* Données de base */

        $list = $this->themeModel->findAll();

        $themes = [];

        $canAdd = Session::isLoggedIn();

        /* Boucle d'affichage */

        foreach ($list as $theme) {
            // Thème

            $themeId = $theme->id;
            $title = $theme->title;
            $author = $this->themeModel->findUser($themeId);
            $nbExpressions = $this->themeModel->countExpressions($themeId);

            // Auteur

            $username = $author->username;
            $userId = $author->id;

            // Edition

            $belongsTo = $this->themeModel->belongsTo($userId, $themeId);
            $isSuperUser = $this->userModel->isSuperUser($userId);

            $canEdit = $canAdd && ($belongsTo || $isSuperUser);

            // Enregistrement

            $themes[] = [
                "id" => $themeId,
                "title" => $title,
                "author" => $username,
                "nbExpressions" => $nbExpressions,
                "canEdit" => $canEdit
            ];
        }

        /* Rendu */

        echo $this->twig->render("themes.twig", [
            "session" => Session::all(),

            "themes" => $themes,
            "canAdd" => $canAdd,
        ]);
    }

    /**
     * Liste des expressions d'un thème
     */

    public function show($themeId) {
        Session::start();

        // Données

        $theme = $this->themeModel->findOneById($themeId);

        $title = $theme->title;

        $list = $this->themeModel->findExpressions($themeId);

        $expressions = [];

        // Boucle d'affichage

        foreach ($list as $expression) {
            // Lecture

            $id = $expression->id;
            $french = $expression->french;
            $english = $expression->english;
            $phonetics = $expression->phonetics;

            $author = $this->themeModel->findUser($themeId)->username;

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
            "canAdd" => Session::isLoggedIn(),

            "title" => $title,
            "expressions" => $expressions,
        ]);
    }

    /**
     * Ajout d'un nouveau thème
     */

    public function new() {
        Session::start();

        // Utilisateur non connecté

        Session::errorIfNotLoggedIn();

        // Validation

        $validator = new ThemeValidation();

        // Indication

        $validator->setTip("title", "Le titre doit être renseigné et contenir jusqu'à 50 caractères.");

        // Envoi des données

        $errors = [];

        $title = "";

        if (Request::isPost()) {
            sleep(1);

            // Titre

            $title = $validator->title();

            // Validation

            $errors = $validator->getErrors();

            $valid = empty($errors["title"]);

            // Ajout

            $userId = Session::get("user_id");

            if ($valid) {
                $newTheme = [
                    "title" => $title,
                    "user_id" => $userId,
                ];

                $saved = $this->themeModel->insert($newTheme);

                if ($saved) {
                    Session::success("Le thème a bien été ajouté.");
                } else {
                    Session::error();
                }

                $this->index();

                Session::erase();

                return;
            }
        }

        // Rendu

        echo $this->twig->render("themes/new_theme.twig", [
            "session" => Session::all(),

            "tips" => $validator->getTips(),
            "errors" => $errors,

            "title" => $title,
        ]);
    }

    /**
     * Edition d'un thème (titre)
     */

    public function edit($id) {
        Session::start();

        // Utilisateur non connecté

        Session::errorIfNotLoggedIn();

        // Titre

        $theme = $this->themeModel->findOneById($id);

        $id = $theme->id;
        $title = $theme->title;

        // Validation

        $validator = new ThemeValidation();

        // Indication

        $validator->setTip("title", "Le titre doit être renseigné et contenir jusqu'à 50 caractères.");

        // Envoi des données

        $errors = [];

        if (Request::isPost()) {
            sleep(1);

            // Titre

            $title = $validator->title();

            // Validation

            $errors = $validator->getErrors();

            $valid = empty($errors["title"]);

            // Edition

            if ($valid) {
                $saved = $this->themeModel->update($id, $title);

                if ($saved) {
                    Session::success("Le thème a bien été édité.");
                } else {
                    Session::error();
                }

                $this->index();

                Session::erase();

                return;
            }
        }

        // Rendu

        echo $this->twig->render("themes/edit_theme.twig", [
            "session" => Session::all(),

            "tips" => $validator->getTips(),
            "errors" => $errors,

            "id" => $id,
            "title" => $title,
        ]);
    }

    /**
     * Suppression d'un thème (titre)
     */

    public function delete($id) {
        Session::start();

        // Utilisateur non connecté

        Session::errorIfNotLoggedIn();

        // Titre

        $theme = $this->themeModel->findOneById($id);

        $title = $theme->title;

        // Suppression

        if (Request::isPost()) {
            sleep(1);

            $deleted = $this->themeModel->delete($id);

            if ($deleted) {
                Session::success("Le thème a bien été supprimé.");
            } else {
                Session::error();
            }

            $this->index();

            Session::erase();

            return;
        }

        // Rendu

        echo $this->twig->render("themes/delete_theme.twig", [
            "session" => Session::all(),
            
            "id" => $id,
            "title" => $title,
        ]);
    }

    // Jeu de flashcards

    public function start($id) {
        Session::start();

        // Rendu

        echo $this->twig->render("themes/game.twig", [
            "session" => Session::all(),

            "title" => "Mon thème"
        ]);
    }
}