<?php

namespace app\controllers;

use app\core\Request;
use app\core\Session;

use app\models\Expression;

use app\controllers\Controller;

use app\validation\ExpressionValidation;

class ExpressionsController extends Controller {
    private $expressionModel;

    // Constructeur

    public function __construct() {
        $this->init();

        $this->expressionModel = new Expression();
    }

    // Ajout d'une nouvelle expression

    public function new($themeId) {
        Session::start();

        // Utilisateur non connecté

        Session::errorIfNotLoggedIn();

        // Validation

        $validator = new ExpressionValidation();

        // Indications

        $validator->setTip("french", "L'expression doit être renseignée et contenir jusqu'à 255 caractères.");
        $validator->setTip("english", "La traduction doit être renseignée et contenir jusqu'à 255 caractères.");
        $validator->setTip("phonetics", "La transcription phonétique doit être renseignée et contenir jusqu'à 255 caractères.");

        // Envoi des données

        $errors = [];

        $french = "";
        $english = "";
        $phonetics = "";

        if (Request::isPost()) {
            sleep(1);

            Session::errorIfNotToken();

            // Données

            $french = $validator->french();
            $english = $validator->english();
            $phonetics = $validator->phonetics();

            // Validation

            $errors = $validator->getErrors();

            $valid = empty($errors["french"]) &&
                     empty($errors["english"]) &&
                     empty($errors["phonetics"]);

            // Ajout

            $userId = Session::get("user_id");

            if ($valid) {
                $newExpression = [
                    "french" => $french,
                    "english" => $english,
                    "phonetics" => $phonetics,
                    "user_id" => $userId,
                    "theme_id" => $themeId
                ];

                $saved = $this->expressionModel->insert($newExpression);

                if ($saved) {
                    Session::success("L'expression a bien été ajoutée.");
                } else {
                    Session::error();
                }

                header("Location: http://localhost/en_app/themes/show/$themeId");

                return;
            }
        }

        // Rendu

        echo $this->twig->render("expressions/new_expression.twig", [
            "session" => Session::all(),
            
            "tips" => $validator->getTips(),
            "errors" => $errors,

            "french" => $french,
            "english" => $english,
            "phonetics" => $phonetics
        ]);
    }

    // Edition d'un thème (titre)

    public function edit($id) {
        Session::start();

        // Utilisateur non connecté

        Session::errorIfNotLoggedIn();

        // Données existantes

        $expression = $this->expressionModel->findOneById($id);

        $french = $expression->french;
        $english = $expression->english;
        $phonetics = $expression->phonetics;

        $themeId = $expression->theme_id;

        // Validation

        $validator = new ExpressionValidation();

        // Indications

        $validator->setTip("french", "L'expression doit être renseignée et contenir jusqu'à 255 caractères.");
        $validator->setTip("english", "La traduction doit être renseignée et contenir jusqu'à 255 caractères.");
        $validator->setTip("phonetics", "La transcription phonétique doit être renseignée et contenir jusqu'à 255 caractères.");

        // Envoi des données

        $errors = [];

        if (Request::isPost()) {
            sleep(1);

            Session::errorIfNotToken();

            // Données

            $french = $validator->french();
            $english = $validator->english();
            $phonetics = $validator->phonetics();

            // Validation

            $errors = $validator->getErrors();

            $valid = empty($errors["french"]) &&
                     empty($errors["english"]) &&
                     empty($errors["phonetics"]);

            // Edition

            if ($valid) {
                $newExpression = [
                    "french" => $french,
                    "english" => $english,
                    "phonetics" => $phonetics,
                ];

                $saved = $this->expressionModel->update($id, $newExpression);

                if ($saved) {
                    Session::success("L'expression a bien été éditée.");
                } else {
                    Session::error();
                }

                header("Location: http://localhost/en_app/themes/show/$themeId");

                return;
            }
        }

        // Rendu

        echo $this->twig->render("expressions/edit_expression.twig", [
            "session" => Session::all(),
            
            "tips" => $validator->getTips(),
            "errors" => $errors,

            "french" => $french,
            "english" => $english,
            "phonetics" => $phonetics
        ]);
    }

    // Suppression d'un thème (titre)

    public function delete($id) {
        Session::start();

        // Rendu

        echo $this->twig->render("expressions/delete_expression.twig", [
            "session" => Session::all(),
            "title" => "Mon thème",
        ]);
    }
}