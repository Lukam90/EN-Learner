<?php

namespace app\core;

use app\controllers\HomeController;
use app\controllers\UsersController;
use app\controllers\ThemesController;
use app\controllers\NotFoundController;
use app\controllers\ExpressionsController;

class Router {
    private $controller;
    private $url;
    private $page;
    private $parameter;
    private $id;

    // Constructeurs

    public function __construct() {
        $this->url = "";
        $this->page = "home";
        $this->parameter = "";
        $this->id = 0;
    }

    // Définition de l'URL

    public function setUrl() {
        if (Get::has("url")) {
            $this->url = rtrim(Get::var("url"), "/");
        }

        if (Post::has("url")) {
            $this->url = rtrim(Post::var("url"), "/");
        }

        $this->url = filter_var($this->url, FILTER_SANITIZE_URL);
        $this->url = explode("/", $this->url);
    }

    // Définition de la page

    public function setPage() {
        if (strlen($this->url[0]) > 0) {
            $this->page = $this->url[0];
        }
    }

    // Définition du paramètre

    public function setParameter() {
        $this->parameter = $this->url[1];
    }

    // Définition de l'ID

    public function setID() {
        $this->id = (int) $this->url[2];
    }

    // Correspondance de paramètres

    public function finds($values) {
        foreach ($values as $value) {
            if ($value == $this->parameter) {
                return true;
            }
        }

        return false;
    }

    // Présence d'un paramètre

    public function hasParameter() {
        return isset($this->url[1]);
    }

    // Présence d'un ID

    public function hasID() {
        return isset($this->url[2]);
    }

    /* Redirections */

    // Redirection de la page

    public function redirectPage() {
        switch ($this->page) {
            case "home":
                $this->redirectHome();
                
                break;
            case "login":
            case "logout":
            case "register":
            case "reset":
            case "confirm":
                $methodName = $this->page;

                $this->controller = new UsersController();
                $this->controller->$methodName();

                break;

            case "users":
                $this->redirectUsers();

                break;
            case "themes":
                $this->redirectThemes();

                break;
            case "expressions":
                $this->redirectExpressions();

                break;
            default:
                $this->redirect404();

                break;
        }
    }

    // Redirection vers la page d'accueil

    public function redirectHome() {
        $this->controller = new HomeController();
        $this->controller->index();
    }

    // Redirection 404 : Non trouvé

    public function redirect404() {
        header("HTTP/1.0 404 Not Found");

        $this->controller = new NotFoundController();
        $this->controller->render();
    }

    // Redirection des utilisateurs

    public function redirectUsers() {
        $this->controller = new UsersController();

        if ($this->hasParameter()) {
            $this->setParameter();

            $withId = $this->finds(["profile", "edit", "delete"]);

            $methodName = $this->parameter;

            // Route avec ID (ex : /users/edit/2)

            if ($withId) {
                if ($this->hasID()) {
                    $this->setID();

                    $this->controller->$methodName($this->id);
                } else {
                    $this->redirect404();
                }
            } else { // Route sans ID (ex : /users/edit)
                $this->redirect404();
            }
        } else { // Liste des utilisateurs (/users)
            $this->controller->index();
        }
    }

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
                    $this->redirect404();
                }
            } else { // Route avec paramètre inconnu (ex : /themes/inconnu)
                $this->redirect404();
            }
        } else { // Route sans paramètres (/themes)
            $this->controller->index();
        }
    }

    // Redirection des expressions

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
                    $this->redirect404();
                }
            } else { // Route sans ID (ex : /expressions/edit)
                $this->redirect404();
            }
        } else { // Route sans paramètres (ex : /expressions)
            $this->redirect404();
        }
    }

    /* Initialisation / Base du routeur */

    public function init() {
        $this->setUrl();
        $this->setPage();

        $this->redirectPage();
    }
}