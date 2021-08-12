<?php

namespace app\core;

use app\controllers\HomeController;
use app\controllers\TestsController;
use app\controllers\NotFoundController;

abstract class Redirection {
    // Redirection vers la page d'accueil

    public static function home() {
        $controller = new HomeController();
        $controller->index();
    }

    // Redirection 404 : Page non trouvée

    public static function notFound() {
        header("HTTP/1.0 404 Not Found");

        $controller = new NotFoundController();
        $controller->render();
    }

    // Redirection vers la page de tests

    public static function tests() {
        $controller = new TestsController();
        $controller->render();
    }
}