<?php

namespace app\controllers;

use app\core\Session;

use app\models\Expression;
use app\controllers\Controller;

class ExpressionsController extends Controller {
    private $expressionModel;

    // Constructeur

    public function __construct() {
        $this->init();

        $this->expressionModel = new Expression();
    }

    // Ajout d'une nouvelle expression

    public function new() {
        // FR, EN, phonétique, user ID, theme ID

        // Rendu

        echo $this->twig->render("expressions/new_expression.twig", [
            "session" => Session::all(),
            "key" => "value",
        ]);
    }

    // Edition d'un thème (titre)

    public function edit() {
        // 

        // Rendu

        echo $this->twig->render("expressions/edit_expression.twig", [
            "session" => Session::all(),
            "title" => "Mon thème",
        ]);
    }

    // Suppression d'un thème (titre)

    public function delete($id) {
        // 

        // Rendu

        echo $this->twig->render("expressions/delete_expression.twig", [
            "session" => Session::all(),
            "title" => "Mon thème",
        ]);
    }
}