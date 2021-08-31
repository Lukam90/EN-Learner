<?php

namespace app\controllers;

use app\core\Post;
use app\core\Request;
use app\core\Session;
use app\core\Redirection;

use app\controllers\Controller;

class SlidesController extends Controller {
    public function __construct() {
        $this->init();
    }

    public function render() {
        Session::start();

        echo $this->twig->render("slides.twig", [
            "session" => Session::all(),

            "pageTitle" => "Présentation"
        ]);
    }
}