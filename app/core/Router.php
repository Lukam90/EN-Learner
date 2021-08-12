<?php

namespace app\core;

use app\core\Redirection;

use app\controllers\UsersController;
use app\controllers\ThemesController;
use app\controllers\ExpressionsController;

abstract class Router {
    /* Paramètres */

    // Définition de l'URL

    public static function url() {
        $url = "/";

        if (Get::has("url")) {
            $url = rtrim(Get::var("url"), "/");
        }

        if (Post::has("url")) {
            $url = rtrim(Post::var("url"), "/");
        }

        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode("/", $url);

        return $url;
    }

    // Définition de la page

    public static function page($url) {
        $page = "home";

        if (strlen($url[0]) > 0) {
            $page = $url[0];
        }

        return $page;
    }

    /* Redirections */

    // Redirection de la page

    public static function init() {
        $url = self::url();
        $page = self::page($url);

        switch ($page) {
            case "home":
                Redirection::home();
                
                break;
            case "login":
            case "logout":
            case "register":
            case "reset":
            case "confirm":
                Redirection::auth($page);

                break;

            case "users":
                Redirection::users($url);

                break;
                
            case "themes":
                Redirection::themes($url);

                break;
            case "expressions":
                //$this->redirectExpressions();

                break;
            case "tests":
                Redirection::tests();

                break;
            default:
                Redirection::notFound();

                break;
        }
    }

    /** Suite à réadapter */

    /*

    // Redirection des thèmes

    public function redirectThemes() {
        $this->controller = new ThemesController();

        // Route avec paramètre (ex : /themes/action)

        if ($this->hasParameter()) {
            $this->setParameter();

            $withId = $this->finds(["show", "edit", "delete", "start"]);

            if ($this->parameter == "new") {
                $this->controller->new();
            } else if ($withId) { // Route avec ID (ex : /themes/action/x)
                if ($this->hasID()) {
                    $this->setID();

                    $methodName = $this->parameter;

                    $this->controller->$methodName($this->id);
                } else {
                    Redirection::notFound();
                }
            } else { // Route avec paramètre inconnu (ex : /themes/inconnu)
                Redirection::notFound();
            }
        } else { // Route sans paramètres (/themes)
            $this->controller->index();
        }
    }

    */

    // Redirection des expressions

    /*

    public function redirectExpressions() {
        $this->controller = new ExpressionsController();

        // Route avec paramètre (ex : /expressions/action)

        if ($this->hasParameter()) {
            $this->setParameter();

            $withId = $this->finds(["edit", "delete"]);

            if ($this->parameter == "new") {
                $this->controller->new();
            } else if ($withId) { // Route avec ID (ex : /expressions/edit/1)
                if ($this->hasID()) {
                    $this->setID();

                    $methodName = $this->parameter;

                    $this->controller->$methodName($this->id);
                } else {
                    Redirection::notFound();
                }
            } else { // Route sans ID (ex : /expressions/edit)
                Redirection::notFound();
            }
        } else { // Route sans paramètres (ex : /expressions)
            Redirection::notFound();
        }
    }
    */
}