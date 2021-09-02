<?php

namespace app\controllers;

use app\core\Post;
use app\core\Request;
use app\core\Session;
use app\core\Security;
use app\core\Redirection;

use app\models\Theme;
use app\models\User;
use app\models\Expression;

use app\controllers\DataController;

use app\validation\ThemeValidation;

class ThemesController extends DataController {
    // Constantes

    const TIP_TITLE = "Le titre doit être renseigné et contenir jusqu'à 50 caractères.";

    // Constructeur

    public function __construct() {
        $this->init();

        $this->themeModel = new Theme();
        $this->userModel = new User();
        $this->expressionModel = new Expression();

        $this->validator = new ThemeValidation();
    }

    /**
     * Fonctions utilitaires
     */

    // Indications

    public function setTip() {
        $this->validator->setTip("title", self::TIP_TITLE);
    }

    // Thème > Edition / Suppression

    public function canEditTheme($themeId) {
        $userId = Session::get("user_id");

        $belongsTo = $this->ownsTheme($themeId);
        $isSuperUser = $this->isSuperUser($userId);

        $isAuthorized = $belongsTo || $isSuperUser;

        return $isAuthorized;
    }

    // Thème > Autorisation

    public function isAuthorizedForTheme($themeId) {
        if (! $this->canEditTheme($themeId) ) {
            Session::alert("Vous n'êtes pas autorisé(e) à effectuer cette action.");

            Redirection::to("/themes");

            exit;
        }
    }

    // Sélection des thèmes

    public function getThemes() {
        return $this->themeModel->findAll();
    }

    // L'utilisateur est l'auteur du thème

    public function ownsTheme($themeId) {
        $userId = Session::get("user_id");

        return $this->themeModel->belongsTo($userId, $themeId);
    }

    // Auteur d'un thème

    public function getAuthorForTheme($themeId) {
        $user = $this->themeModel->findUser($themeId);

        return $user["username"];
    }
    
    /* CRUD */

    // Nouveau thème

    public function insertTheme($title) {
        $theme = [
            "title" => $title,
            "user_id" => Session::get("user_id"),
        ];

        $saved = $this->themeModel->insert($theme);

        if ($saved) {
            Session::success("Le thème a bien été ajouté.");
        } else {
            Session::error();
        }

        Redirection::to("/themes");

        exit;
    }

    // Edition d'un thème

    public function updateTheme($themeId, $title) {
        $saved = $this->themeModel->update($themeId, $title);

        if ($saved) {
            Session::success("Le thème a bien été édité.");
        } else {
            Session::error();
        }

        Redirection::to("/themes");

        exit;
    }

    // Suppression d'un thème

    public function deleteTheme($themeId) {
        $deleted = $this->themeModel->delete($themeId);

        if ($deleted) {
            Session::success("Le thème a bien été supprimé.");
        } else {
            Session::error();
        }

        Redirection::to("/themes");

        exit;
    }

    /* Validation */

    // Titre validé

    public function getCheckedTitle() {
        return $this->validator->checkTitle();
    }

    /**
     * Pages
     */

    // Liste des thèmes

    public function index() {
        Session::start();

        /* Données de base */

        $list = $this->getThemes();

        $canAdd = Session::isLoggedIn();

        $themes = [];

        /* Boucle d'affichage */

        foreach ($list as $theme) {
            // Thème

            $themeId = $theme["id"];

            $title = $theme["title"];

            $author = $this->getAuthorForTheme($themeId);
            $nbExpressions = $this->getNbExpressions($themeId);

            $canEdit = $canAdd && $this->canEditTheme($themeId);

            // Enregistrement

            $themes[] = [
                "id" => $themeId,
                "title" => $title,
                "author" => $author,
                "nbExpressions" => $nbExpressions,
                "canEdit" => $canEdit
            ];
        }

        /* Rendu */

        $this->render("themes.twig", [
            "session" => Session::all(),

            "pageTitle" => "Thèmes",

            "themes" => $themes,
            "canAdd" => $canAdd,
        ]);

        Session::erase();
    }

    /**
     * Liste des expressions d'un thème
     */

    public function show($themeId) {
        Session::start();

        // Thème existant

        $theme = $this->getOneThemeById($themeId);

        $this->themeExists($themeId);

        // Thème courant

        $title = $theme["title"];

        // Données

        $list = $this->getExpressions($themeId);

        $expressions = [];

        // Boucle d'affichage

        foreach ($list as $expression) {
            // Lecture

            $expressionId = $expression["id"];

            $french = $expression["french"];
            $english = $expression["english"];
            $phonetics = $expression["phonetics"];

            $author = $this->getAuthorForExpression($expressionId);

            $canEdit = $this->canEditExpression($expressionId);

            // Enregistrement

            $expressions[] = [
                "id" => $expressionId,
                "french" => $french,
                "english" => $english,
                "phonetics" => $phonetics,
                "author" => $author,
                "canEdit" => $canEdit,
            ];
        }

        // Rendu

        $this->render("themes/show_theme.twig", [
            "session" => Session::all(),
            "canAdd" => Session::isLoggedIn(),

            "pageTitle" => $title,

            "id" => $themeId,
            "expressions" => $expressions,
            "nbExpressions" => count($expressions)
        ]);

        Session::erase();
    }

    /**
     * Ajout d'un nouveau thème
     */

    public function new() {
        Session::start();

        // Utilisateur connecté

        $this->isLoggedIn();

        // Indication

        $this->setTip();

        // Envoi des données

        $errors = [];

        $title = "";

        if (Request::isPost()) {
            // Sécurité

            $this->secure();

            // Titre

            $title = $this->getCheckedTitle();

            // Validation

            $errors = $this->getErrors();

            $valid = empty($errors["title"]);

            // Ajout

            if ($valid) {
                $this->insertTheme($title);
            }
        }

        // Rendu

        $this->render("themes/new_theme.twig", [
            "session" => Session::all(),

            "tips" => $this->getTips(),
            "errors" => $errors,

            "pageTitle" => "Ajout d'un thème",
            "label" => "Ajouter",

            "title" => $title,
        ]);
    }

    

    /**
     * Edition d'un thème (titre)
     */

    public function edit($themeId) {
        Session::start();

        // Utilisateur connecté

        $this->isLoggedIn();

        // Thème existant

        $this->themeExists($themeId);

        // Utilisateur autorisé

        $this->isAuthorizedForTheme($themeId);

        // Thème courant

        $theme = $this->getOneThemeById($themeId);

        $title = $theme["title"];

        // Indication

        $this->setTip();

        // Envoi des données

        $errors = [];

        if (Request::isPost()) {
            // Sécurité

            $this->secure();

            // Titre

            $title = $this->getCheckedTitle();

            // Validation

            $errors = $this->getErrors();

            $valid = empty($errors["title"]);

            // Edition

            if ($valid) {
                $this->updateTheme($themeId, $title);
            }
        }

        // Rendu

        $this->render("themes/edit_theme.twig", [
            "session" => Session::all(),

            "tips" => $this->getTips(),
            "errors" => $errors,

            "id" => $themeId,
            "pageTitle" => "Edition du thème : $title",
            "label" => "Editer",

            "title" => $title,
        ]);
    }

    /**
     * Suppression d'un thème (titre)
     */

    public function delete($themeId) {
        Session::start();

        // Utilisateur connecté

        $this->isLoggedIn();

        // Thème existant

        $this->themeExists($themeId);

        // Utilisateur autorisé

        $this->isAuthorizedForTheme($themeId);

        // Thème courant

        $theme = $this->getOneThemeById($themeId);

        $title = $theme["title"];

        $nbExpressions = $this->getNbExpressions($themeId);

        // Suppression

        if (Request::isPost()) {
            // Sécurité

            $this->secure();

            // Action

            $this->deleteTheme($themeId);
        }

        // Rendu

        $this->render("themes/delete_theme.twig", [
            "session" => Session::all(),

            "pageTitle" => "Suppression du thème : $title",

            "nbExpressions" => $nbExpressions,

            "id" => $themeId,
            "title" => $title
        ]);
    }

    // Jeu de flashcards

    public function start($themeId) {
        Session::start();

        // Thème existant

        $this->themeExists($themeId);

        // Thème courant

        $theme = $this->getOneThemeById($themeId);

        // Données

        $title = $theme["title"];

        $list = $this->getExpressions($themeId);

        $count = count($list);

        $expressions = [];
        $flashcards = [];

        $started = false;

        // Liste initiale

        foreach ($list as $expression) {
            // Lecture

            $french = $expression["french"];
            $english = $expression["english"];
            $phonetics = $expression["phonetics"];

            // Enregistrement

            $expressions[] = [
                "french" => $french,
                "english" => $english,
                "phonetics" => $phonetics
            ];
        }

        // Niveaux de difficulté

        $levels = ["Facile (10)"];

        if ($count >= 15 && $count < 20) {
            $levels = ["Facile (10)", "Moyen (15)"];
        }
        
        if ($count >= 20) {
            $levels = ["Facile (10)", "Moyen (15)", "Difficile (20)"];
        }

        // Lancement du jeu

        if (Request::isPost()) {
            $level = Post::var("level");

            $started = true;

            // Choix du niveau

            switch ($level) {
                case "Facile (10)":
                    $nb = 10;
                    break;
                case "Moyen (15)":
                    $nb = 15;
                    break;
                case "Difficile (20)":
                    $nb = 20;
                    break;
            }

            // Génération des flashcards

            shuffle($expressions);

            for ($i = 0 ; $i < $nb ; $i++) {
                $flashcards[] = $expressions[$i];
            }
        }

        // Rendu

        $pageTitle = "Flashcards > $title";

        $this->render("themes/game.twig", [
            "session" => Session::all(),

            "started" => $started,
            "id" => $themeId,
            "title" => $title,
            "pageTitle" => $pageTitle,
            "levels" => $levels,
            "flashcards" => $flashcards
        ]);
    }
}