<?php

namespace app\controllers;

use app\core\Session;
use app\core\Redirection;

use app\controllers\ModelController;

abstract class DataController extends ModelController {
    /* Attributs */

    // Modèles (Données)

    protected $themeModel;
    protected $expressionModel;

    /**
     * Fonctions utilitaires
     */

    /* Expressions */

    // Expressions d'un thème

    public function getExpressions($themeId) {
        return $this->themeModel->findExpressions($themeId);
    }

    // Nombre d'expressions

    public function getNbExpressions($themeId) {
        return $this->themeModel->countExpressions($themeId);
    }

    // L'utilisateur est l'auteur de l'expression

    public function ownsExpression($expressionId) {
        $userId = Session::get("user_id");

        return $this->expressionModel->belongsTo($userId, $expressionId);
    }

    // Auteur d'une expression

    public function getAuthorForExpression($expressionId) {
        $user = $this->expressionModel->findUser($expressionId);

        return $user["username"];
    }

    // Expression > Edition / Suppression

    public function canEditExpression($expressionId) {
        $userId = Session::get("user_id");

        $belongsTo = $this->ownsExpression($expressionId);
        $isSuperUser = $this->isSuperUser($userId);

        $isAuthorized = $belongsTo || $isSuperUser;

        return $isAuthorized;
    }

    // Expression > Autorisation

    public function isAuthorizedForExpression($expressionId) {
        if (! $this->canEditExpression($expressionId) ) {
            Session::alert("Vous n'êtes pas autorisé(e) à effectuer cette action.");

            Redirection::to("/themes");

            exit;
        }
    }

    /* Thèmes */

    // Sélection du thème courant

    public function getOneThemeById($themeId) {
        return $this->themeModel->findOneById($themeId);
    }

    // Thème existant

    public function themeExists($themeId) {
        $exists = $this->getOneThemeById($themeId);

        if (! $exists) {
            Session::alert("Le thème n'existe pas.");

            Redirection::to("/themes");

            exit;
        }
    }
}