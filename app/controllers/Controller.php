<?php

namespace app\controllers;

use app\core\Request;
use app\core\Session;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller {
    protected $twig; // Moteur de templates (Twig)
    protected $root; // URL de base

    // Initialisation

    public function init() {
        $loader = new FilesystemLoader(dirname(__DIR__) . "/public/views");

        $this->twig = new Environment($loader, [
            'cache' => false,
        ]);

        $this->root = "http://localhost/en_app";

        $this->twig->addGlobal('root', $this->root);
        $this->twig->addGlobal('public', $this->root . "/app/public");
    }

    // Rendu

    public function render($page, $values) {
        echo $this->twig->render($page, $values);
    }

    // Sécurité

    public function secure() {
        sleep(1);

        Session::errorIfNotToken();
    }
}