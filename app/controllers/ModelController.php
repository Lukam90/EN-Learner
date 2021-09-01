<?php

use app\core\Session;

use app\controllers\Controller;

abstract class ModelController extends Controller {
    /* Attributs */

    protected $validator;

    /* Fonctions utilitaires */

    // Sécurité

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

    // Non invité / Déja connecté

    public function alreadyLoggedIn () {
        if (Session::isLoggedIn()) {
            Session::alert("Vous êtes déjà connecté(e).");

            Redirection::to("/");
        }
    }

    // Non connecté

    public function notLoggedIn () {
        if (! Session::isLoggedIn()) {
            Session::alert("Vous devez être connecté(e) pour accéder à cette page.");

            Redirection::to("/");
        }
    }    

    /*
    



    public function () {
        
    }

    public function () {
        
    }

    public function () {
        
    }

    public function () {
        
    }

    public function () {
        
    }

    public function () {
        
    }

    public function () {
        
    }

    public function () {
        
    }
    */
}