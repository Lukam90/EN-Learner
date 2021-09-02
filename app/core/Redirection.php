<?php

namespace app\core;

use app\controllers\HomeController;
use app\controllers\TestsController;
use app\controllers\UsersController;
use app\controllers\ErrorsController;
use app\controllers\SlidesController;
use app\controllers\ThemesController;
use app\controllers\ExpressionsController;

/**
 * Redirection Class
 */

abstract class Redirection {
    /* URLs Management */

    /**
     * Check if a parameter exists
     */

    public static function hasParameter($url) {
        return isset($url[1]);
    }

    /**
     * Check if an ID exists
     */

    public static function hasID($url) {
        return isset($url[2]);
    }

    /**
     * Find an existing parameter (or not)
     */

    public static function finds($parameter, $values) {
        foreach ($values as $element) {
            if ($element == $parameter) {
                return true;
            }
        }

        return false;
    }

    /* Redirections */

    /**
     * Specific Page
     */

    public static function to($path) {
        header("Location: http://localhost/en_app" . $path);
    }

    /**
     * Home Page
     */

    public static function home() {
        $controller = new HomeController();
        $controller->index();
    }

    /**
     * Users Pages
     */

    public static function users($url) {
        $controller = new UsersController();

        if (self::hasParameter($url)) {
            $methodName = $url[1];

            $withId = self::finds($methodName, ["profile", "edit", "delete"]);

            // Route with ID (ex : /users/edit/2)

            if ($withId) {
                if (self::hasID($url)) {
                    $id = (int) $url[2];

                    $controller->$methodName($id);
                } else {
                    self::notFound();
                }
            } else { // Route without ID (ex : /users/edit)
                $controller->$methodName();
            }
        } else { // Users list (/users)
            $controller->index();
        }
    }

    /**
     * Themes pages
     */

    public static function themes($url) {
        $controller = new ThemesController();

        // Route with parameter (ex : /themes/action)

        if (self::hasParameter($url)) {
            $methodName = $url[1];

            $withId = self::finds($methodName, ["show", "edit", "delete", "start"]);

            if ($methodName == "new") { // Add (/themes/new)
                $controller->new();
            } else if ($withId) { // Route with ID (ex : /themes/action/x)
                if (self::hasID($url)) {
                    $id = (int) $url[2];

                    $controller->$methodName($id);
                } else {
                    self::notFound();
                }
            } else { // Route with unknown parameter (ex : /themes/inconnu)
                self::notFound();
            }
        } else { // Route without parameters (/themes)
            $controller->index();
        }
    }

    /**
     * Expressions pages
     */

    public function expressions($url) {
        $controller = new ExpressionsController();

        // Route with parameter (ex : /expressions/action)

        if (self::hasParameter($url)) {
            $methodName = $url[1];

            $withId = self::finds($methodName, ["new", "edit", "delete"]);

            if ($withId) { // Route with ID (ex : /expressions/edit/1)
                if (self::hasID($url)) {
                    $id = (int) $url[2];

                    $controller->$methodName($id);
                } else { // Route without ID (ex : /expressions/edit)
                    self::notFound();
                }
            } else { // Route without ID (ex : /expressions/edit)
                self::notFound();
            }
        } else { // Route without parameters (ex : /expressions)
            self::notFound();
        }
    }

    /**
     * Slides
     */

    public static function slides() {
        $controller = new SlidesController();
        $controller->index();
    }

    /* Errors */

    /**
     * Redirection 403 : Forbidden Access
     */

    public static function notAuthorized() {
        header("HTTP/1.0 403 Forbidden");

        $controller = new ErrorsController();
        $controller->notAuthorized();
    }

    /**
     * Redirection 404 : Page Not Found
     */

    public static function notFound() {
        header("HTTP/1.0 404 Not Found");

        $controller = new ErrorsController();
        $controller->notFound();
    }
}