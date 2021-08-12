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

        echo $this->twig->render("tests.twig", [
            "session" => Session::all(),
        ]);
    }
}