<?php

namespace app\controllers;

use app\core\Session;

use app\controllers\Controller;

class ErrorsController extends Controller {
    public function __construct() {
        $this->init();
    }

    // Erreur 403 : Accès non autorisé

    public function notAuthorized() {
        $this->render("errors/403.twig", [
            "session" => Session::all(),

            "pageTitle" => "403 - Accès non autorisé",
        ]);
    }

    // Erreur 404 : Page non trouvée

    public function notFound() {
        $this->render("errors/404.twig", [
            "session" => Session::all(),

            "pageTitle" => "404 - Page inconnue",
        ]);
    }
}