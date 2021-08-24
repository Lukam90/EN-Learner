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
        echo $this->twig->render("errors/403.twig", [
            "session" => Session::all(),
        ]);
    }

    // Erreur 404 : Page non trouvée

    public function notFound() {
        echo $this->twig->render("errors/404.twig", [
            "session" => Session::all(),
        ]);
    }
}