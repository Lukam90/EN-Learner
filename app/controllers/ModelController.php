<?php

namespace app\controllers;

use app\core\Session;

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

        Session::expiredToken();
    }

    // Indications

    public function getTips() {
        return $this->validator->getTips();
    }

    // Erreurs

    public function getErrors() {
        return $this->validator->getErrors();
    }

    // Utilisateur invité / déconnecté

    public function isGuest () {
        if (Session::isLoggedIn()) {
            Session::alert("Vous êtes déjà connecté(e).");

            Redirection::to("/");
        }
    }

    // Utilisateur connecté

    public function isLoggedIn() {
        if (! Session::isLoggedIn()) {
            Session::alert("Vous devez être connecté(e) pour accéder à cette page.");

            Redirection::to("/");
        }
    }

    // L'utilisateur est un modérateur ou un administrateur
    
    public function isSuperUser() {
        $userId = Session::get("user_id");
        
        return $this->userModel->isSuperUser($userId);
    }
}