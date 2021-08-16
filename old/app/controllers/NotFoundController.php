<?php

namespace app\controllers;

use app\controllers\Controller;

class NotFoundController extends Controller {
    public function __construct() {
        $this->init();
    }

    public function render() {
        echo $this->twig->render("errors/404.twig", [
            "session" => Session::all(),
        ]);
    }
}