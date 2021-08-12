<?php

namespace app\core;

use app\controllers\HomeController;
use app\controllers\TestsController;
use app\controllers\UsersController;
use app\controllers\ErrorsController;
use app\controllers\ThemesController;

abstract class Redirection {
    /* Gestion des URLS */

    // Présence d'un paramètre

    public static function hasParameter($url) {
        return isset($url[1]);
    }

    // Présence d'un ID

    public static function hasID($url) {
        return isset($url[2]);
    }

    // Correspondance de paramètres

    public static function finds($parameter, $values) {
        foreach ($values as $element) {
            if ($element == $parameter) {
                return true;
            }
        }

        return false;
    }

    /* Redirections */

    // Redirection vers la page d'accueil

    public static function home() {
        $controller = new HomeController();
        $controller->index();
    }

    // Redirection vers les pages d'authentification et d'inscription

    public static function auth($methodName) {
        $controller = new UsersController();
        $controller->$methodName();
    }

    // Redirection des utilisateurs

    public static function users($url) {
        $controller = new UsersController();

        if (self::hasParameter($url)) {
            $methodName = $url[1];

            $withId = self::finds($methodName, ["profile", "edit", "delete"]);

            // Route avec ID (ex : /users/edit/2)

            if ($withId) {
                if (self::hasID($url)) {
                    $id = (int) $url[2];

                    $controller->$methodName($id);
                } else {
                    self::notFound();
                }
            } else { // Route sans ID (ex : /users/edit)
                self::notFound();
            }
        } else { // Liste des utilisateurs (/users)
            $controller->index();
        }
    }

    // Redirection des thèmes

    public static function themes($url) {
        $controller = new ThemesController();

        // Route avec paramètre (ex : /themes/action)

        if (self::hasParameter($url)) {
            $methodName = $url[1];

            $withId = self::finds($methodName, ["show", "edit", "delete", "start"]);

            if ($methodName == "new") { // Ajout (/themes/new)
                $controller->new();
            } else if ($withId) { // Route avec ID (ex : /themes/action/x)
                if (self::hasID($url[2])) {
                    $id = (int) $url[2];

                    $controller->$methodName($id);
                } else {
                    Redirection::notFound();
                }
            } else { // Route avec paramètre inconnu (ex : /themes/inconnu)
                Redirection::notFound();
            }
        } else { // Route sans paramètres (/themes)
            $controller->index();
        }
    }

    // Redirection vers la page de tests

    public static function tests() {
        $controller = new TestsController();
        $controller->render();
    }

    /* Erreurs */

    // Redirection 403 : Accès non autorisé

    public static function notAuthorized() {
        header("HTTP/1.0 403 Forbidden");

        $controller = new ErrorsController();
        $controller->notAuthorized();
    }

    // Redirection 404 : Page non trouvée

    public static function notFound() {
        header("HTTP/1.0 404 Not Found");

        $controller = new ErrorsController();
        $controller->notFound();
    }
}