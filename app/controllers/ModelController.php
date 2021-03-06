<?php

namespace app\controllers;

use app\core\Security;
use app\core\Session;
use app\core\Redirection;

use app\controllers\Controller;

abstract class ModelController extends Controller {
    /* Attributs */

    // Validateur

    protected $validator;

    // Modèle (Utilisateurs)

    protected $userModel;

    /* Fonctions utilitaires */

    // Sécurité (DDoS, CSRF)

    public function secure() {
        sleep(1);

        Security::expiredToken();
    }

    // Indications

    public function getTips() {
        return $this->validator->getTips();
    }

    // Erreurs

    public function getErrors() {
        return $this->validator->getErrors();
    }

    // Utilisateur connecté

    public function isLoggedIn() {
        if (! Session::isLoggedIn()) {
            Session::alert("Vous devez être connecté(e) pour accéder à cette page.");

            Redirection::to("/");

            exit;
        }
    }

    // L'utilisateur est un modérateur ou un administrateur
    
    public function isSuperUser() {
        $userId = Session::get("user_id");
        
        return $this->userModel->isSuperUser($userId);
    }
}