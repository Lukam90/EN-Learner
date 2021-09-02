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

    public function index() {
        Session::start();

        $this->render("slides.twig", [
            "session" => Session::all(),

            "pageTitle" => "Présentation"
        ]);
    }
}