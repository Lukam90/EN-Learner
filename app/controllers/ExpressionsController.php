<?php

namespace app\controllers;

use app\core\Redirection;
use app\core\Request;
use app\core\Session;

use app\models\Theme;
use app\models\Expression;

use app\controllers\DataController;

use app\validation\ExpressionValidation;

class ExpressionsController extends DataController {
    // Modèle

    private $expressionModel;

    // Constantes

    const TIP_FRENCH = "L'expression doit être renseignée et contenir jusqu'à 255 caractères.";
    const TIP_ENGLISH = "La traduction doit être renseignée et contenir jusqu'à 255 caractères.";
    const TIP_PHONETICS = "La transcription phonétique doit être renseignée et contenir jusqu'à 255 caractères.";

    // Constructeur

    public function __construct() {
        $this->init();

        $this->expressionModel = new Expression();

        $this->validator = new ExpressionValidation();
    }

    /**
     * Fonctions utilitaires
     */

    /* Expressions */

    // Sélection d'une expression

    public function getOneById($expressionId) {
        return $this->expressionModel->findOneById($expressionId);
    }

    // Existence d'une expression

    public function exists($expressionId) {
        $exists = $this->getOneById($expressionId);
    
        if (! $exists) {
            Session::alert("L'expression n'existe pas.");
    
            Redirection::to("/themes");
    
            return;
        }
    }

    /* CRUD */

    // Ajout d'une nouvelle expression

    public function insertExpression($themeId, $values) {
        $userId = Session::get("user_id");

        $newExpression = [
            "french" => $values["french"],
            "english" => $values["english"],
            "phonetics" => $values["phonetics"],

            "user_id" => $userId,
            "theme_id" => $themeId
        ];

        $saved = $this->expressionModel->insert($newExpression);

        if ($saved) {
            Session::success("L'expression a bien été ajoutée.");
        } else {
            Session::error();
        }

        Redirection::to("/themes/show/$themeId");

        return;
    }

    // Edition d'une expression

    public function updateExpression($expressionId, $themeId, $values) {
        $newExpression = [
            "french" => $values["french"],
            "english" => $values["english"],
            "phonetics" => $values["phonetics"],
        ];

        $saved = $this->expressionModel->update($expressionId, $newExpression);

        if ($saved) {
            Session::success("L'expression a bien été éditée.");
        } else {
            Session::error();
        }

        Redirection::to("/themes/show/$themeId");

        return;
    }

    // Suppression d'une expression

    public function deleteExpression($expressionId, $themeId) {
        $deleted = $this->expressionModel->delete($expressionId);

        if ($deleted) {
            Session::success("L'expression a bien été supprimée.");
        } else {
            Session::error();
        }

        Redirection::to("/themes/show/$themeId");

        return;
    }

    /* Validation */

    // Indications

    public function setTips() {
        $this->validator->setTip("french", self::TIP_FRENCH);
        $this->validator->setTip("english", self::TIP_ENGLISH);
        $this->validator->setTip("phonetics", self::TIP_PHONETICS);
    }

    // Expression

    public function getCheckedFrench() {
        return $this->validator->checkFrench();
    }

    // Traduction

    public function getCheckedEnglish() {
        return $this->validator->checkEnglish();
    }

    // Transcription phonétique

    public function getCheckedPhonetics() {
        return $this->validator->checkPhonetics();
    }

    // Formulaire d'ajout et d'édition

    public function validateForm() {
        $errors = $this->getErrors();

        return empty($errors["french"]) &&
               empty($errors["english"]) &&
               empty($errors["phonetics"]);
    }

    /**
     * Pages
     */

    // Ajout d'une nouvelle expression

    public function new($themeId) {
        Session::start();

        // Utilisateur connecté

        $this->isLoggedIn();

        // Existence du thème

        //Session::errorIfThemeNotExists($themeId);

        // Indications

        $this->setTips();

        // Envoi des données

        $errors = [];

        $french = "";
        $english = "";
        $phonetics = "";

        if (Request::isPost()) {
            // Sécurité

            $this->secure();

            // Données

            $french = $this->getCheckedFrench();
            $english = $this->getCheckedEnglish();
            $phonetics = $this->getCheckedPhonetics();

            // Validation

            $errors = $this->getErrors();

            $valid = $this->validateForm();

            // Ajout

            if ($valid) {
                $values = [
                    "french" => $french,
                    "english" => $english,
                    "phonetics" => $phonetics,
                ];

                $this->insertExpression($themeId, $values);
            }
        }

        // Rendu

        $this->render("expressions/new_expression.twig", [
            "session" => Session::all(),
            
            "label" => "Ajouter",
            "tips" => $this->getTips(),
            "errors" => $errors,

            "pageTitle" => "Ajout d'une expression",

            "id" => $themeId,
            "themeId" => $themeId,

            "french" => $french,
            "english" => $english,
            "phonetics" => $phonetics
        ]);
    }

    // Edition d'une expression

    public function edit($expressionId) {
        Session::start();

        // Utilisateur connecté

        $this->isLoggedIn();

        // Expression existante

        $this->exists($expressionId);

        // Utilisateur autorisé

        $this->isAuthorizedForExpression($expressionId, $themeId);

        // Données existantes

        $expression = $this->getOneById($id);

        $french = $expression["french"];
        $english = $expression["english"];
        $phonetics = $expression["phonetics"];

        $themeId = $expression["theme_id"];

        // Indications

        $this->setTips();

        // Envoi des données

        $errors = [];

        if (Request::isPost()) {
            // Sécurité

            $this->secure();

            // Données

            $french = $this->getCheckedFrench();
            $english = $this->getCheckedEnglish();
            $phonetics = $this->getCheckedPhonetics();

            // Validation

            $errors = $this->getErrors();

            $valid = $this->validateForm();

            // Edition

            if ($valid) {
                $values = [
                    "french" => $french,
                    "english" => $english,
                    "phonetics" => $phonetics
                ];

                $this->updateExpression($expressionId, $themeId, $values);
            }
        }

        // Rendu

        $this->render("expressions/edit_expression.twig", [
            "session" => Session::all(),
            
            "tips" => $this->getTips(),
            "errors" => $errors,

            "pageTitle" => "Edition de l'expression",
            "label" => "Editer",

            "id" => $expressionId,
            "themeId" => $themeId,

            "french" => $french,
            "english" => $english,
            "phonetics" => $phonetics
        ]);
    }

    // Suppression d'une expression

    public function delete($expressionId) {
        Session::start();

        // Utilisateur connecté

        $this->isLoggedIn();

        // Expression existante

        $this->exists($expressionId);

        // Utilisateur autorisé

        //

        // Expression courante

        $expression = $this->getOneById($expressionId);

        $french = $expression["french"];
        $english = $expression["english"];
        $phonetics = $expression["phonetics"];

        $themeId = $expression["theme_id"];

        // Suppression

        if (Request::isPost()) {
            // Sécurité

            $this->secure();

            // Action

            $this->deleteExpression($expressionId, $themeId);
        }

        // Rendu

        $this->render("expressions/delete_expression.twig", [
            "session" => Session::all(),

            "pageTitle" => "Suppression de l'expression",

            "id" => $id,
            "themeId" => $themeId,

            "french" => $french,
            "english" => $english,
            "phonetics" => $phonetics
        ]);
    }
}