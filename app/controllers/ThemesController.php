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

use app\controllers\ModelController;

use app\validation\ThemeValidation;

class ThemesController extends ModelController {
    // Modèles

    private $themeModel;
    private $userModel;
    private $expressionModel;

    // Validateur

    private $validator;

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

    // Autorisation > Edition / Suppression
    // Thème / Expression

    public function canEditTheme($themeId) {
        $userId = Session::get("user_id");

        $belongsTo = $this->themeModel->belongsTo($userId, $themeId);
        $isSuperUser = $this->userModel->isSuperUser($userId);

        $isAuthorized = $belongsTo || $isSuperUser;

        return $isAuthorized;
    }

    // Si non autorisé

    public function stopIfErrors($themeId) {
        // Utilisateur non connecté

        Session::errorIfNotLoggedIn();

        // Thème non existant

        Session::errorIfThemeNotExists($themeId);

        // Edition / Suppression

        if (! canEditTheme($themeId) ) {
            Session::alert("Vous n'êtes pas autorisé(e) à effectuer cette action.");

            Redirection::to("/themes");

            return;
        }
    }

    // Sélection des thèmes

    public function getThemes() {
        return $this->themeModel->findAll();
    }

    // Sélection du thème courant

    public function getCurrentTheme($themeId) {
        return $this->themeModel->findOneById($themeId);
    }

    // Thème inexistant > Erreur

    public function themeNotExists($theme) {
        if (! $theme) {
            Session::alert("Le thème n'existe pas.");

            Redirection::to("/themes");

            return;
        }
    }

    // Auteur d'un thème

    public function getAuthor($themeId) {
        return $this->themeModel->findUser($themeId);
    }
    
    // Nombre d'expressions

    public function getNbExpressions($themeId) {
        return $this->themeModel->countExpressions($themeId);
    }

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

        return;
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

        return;
    }

    // Titre validé

    public function getCheckedTitle() {
        return $this->validator->checkTitle();
    }

    /*

    // 

    public function () {
        
    }

    // 

    public function () {
        
    }

    // 

    public function () {
        
    }

    // 

    public function () {
        
    }

    // 

    public function () {
        
    }

    // %

    public function () {
        
    }

    // %

    public function () {
        
    }

    // %

    public function () {
        
    }

    */

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

            $themeId = $theme->id;

            $author = $this->getAuthor($themeId);
            $nbExpressions = $this->getNbExpressions($themeId);

            $canEdit = $canAdd && $this->canEditTheme($themeId);

            // Enregistrement

            $themes[] = [
                "id" => $themeId,
                "title" => $theme->title,
                "author" => $author->username,
                "nbExpressions" => $nbExpressions,
                "canEdit" => $canEdit
            ];
        }

        /* Rendu */

        echo $this->twig->render("themes.twig", [
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

        // Thème courant

        $theme = $this->getCurrentTheme($themeId);

        Session::errorIfThemeNotExists($themeId);

        // Données

        $list = $this->themeModel->findExpressions($themeId);

        $expressions = [];

        // Boucle d'affichage

        $userId = Session::get("user_id");

        foreach ($list as $expression) {
            $expressionId = $expression->id;

            $author = $this->expressionModel->findUser($expressionId)->username;

            $belongsTo = $this->expressionModel->belongsTo($userId, $expressionId);
            $isSuperUser = $this->userModel->isSuperUser($userId);

            $canEdit = $belongsTo || $isSuperUser;

            // Enregistrement

            $expressions[] = [
                "id" => $expressionId,
                "french" => $expression->french,
                "english" => $expression->english,
                "phonetics" => $expression->phonetics,
                "author" => $author,
                "canEdit" => $canEdit,
            ];
        }

        // Rendu

        echo $this->twig->render("themes/show_theme.twig", [
            "session" => Session::all(),
            "canAdd" => Session::isLoggedIn(),

            "pageTitle" => $theme->title,

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

        // Utilisateur non connecté

        Session::errorIfNotLoggedIn();

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

        echo $this->twig->render("themes/new_theme.twig", [
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

        $this->canEditTheme($themeId);

        // Thème courant

        $theme = $this->getCurrentTheme($themeId);

        $title = $theme->title;

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

        echo $this->twig->render("themes/edit_theme.twig", [
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

        $this->stopIfErrors();

        // Thème existant

        $theme = $this->themeModel->findOneById($themeId);

        $title = $theme->title;

        $nbExpressions = $this->themeModel->countExpressions($themeId);

        // Suppression

        if (Request::isPost()) {
            sleep(1);

            Session::errorIfNotToken();

            $deleted = $this->themeModel->delete($themeId);

            if ($deleted) {
                Session::success("Le thème a bien été supprimé.");
            } else {
                Session::error();
            }

            Redirection::to("/themes");

            return;
        }

        // Rendu

        echo $this->twig->render("themes/delete_theme.twig", [
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

        // Thème courant

        $theme = $this->themeModel->findOneById($themeId);

        $this->themeNotExists();

        // Données

        $title = $theme->title;

        $list = $this->themeModel->findExpressions($themeId);

        $count = count($list);        

        $expressions = [];

        $flashcards = [];

        $started = false;

        // Liste initiale

        foreach ($list as $expression) {
            // Lecture

            $french = $expression->french;
            $english = $expression->english;
            $phonetics = $expression->phonetics;

            // Enregistrement

            $expressions[] = [
                "french" => $french,
                "english" => $english,
                "phonetics" => $phonetics
            ];
        }

        // Niveaux de difficulté

        $levels = ["Facile"];

        if ($count >= 15 && $count < 20) {
            $levels = ["Facile", "Moyen"];
        }
        
        if ($count >= 20) {
            $levels = ["Facile", "Moyen", "Difficile"];
        }

        // Lancement du jeu

        if (Request::isPost()) {
            $level = Post::var("level");

            $started = true;

            // Choix du niveau

            switch ($level) {
                case "Facile":
                    $nb = 10;
                    break;
                case "Moyen":
                    $nb = 15;
                    break;
                case "Difficile":
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

        echo $this->twig->render("themes/game.twig", [
            "session" => Session::all(),

            "started" => $started,
            "id" => $id,
            "title" => $title,
            "pageTitle" => $pageTitle,
            "levels" => $levels,
            "flashcards" => $flashcards
        ]);
    }
}