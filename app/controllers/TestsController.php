<?php

namespace app\controllers;

use app\core\Post;
use app\core\Request;
use app\core\Session;
use app\core\Redirection;

use app\controllers\Controller;

class TestsController extends Controller {
    public function __construct() {
        $this->init();
    }

    public function render() {
        if (Request::isPost()) {
            Session::success("Ceci est un message de confirmation.");
            Session::alert("Ceci est un message d'erreur.");

            Redirection::home();

            return;
        }

        $auth = ["register", "login", "logout", "reset", "confirm"];
        $themes = ["themes", "themes/show/1", "themes/new", "themes/edit/1", "themes/delete/1"];
        $users = ["users", "users/profile/1", "users/edit/1", "users/delete/1"];
        $expressions = ["expressions/new", "expressions/edit/1", "expressions/delete/1"];

        echo $this->twig->render("tests.twig", [
            "session" => Session::all(),

            "auth" => $auth,
            "themes" => $themes,
            "users" => $users,
            "expressions" => $expressions
        ]);
    }
}