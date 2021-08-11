<?php

namespace app\controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller {
    protected $twig;

    public function init() {
        // Moteur de templates (Twig)

        $loader = new FilesystemLoader(dirname(__DIR__) . "/public/views");

        $this->twig = new Environment($loader, [
            'cache' => false,
        ]);

        $root = "http://localhost/en_app";

        $this->twig->addGlobal('root', $root);
        $this->twig->addGlobal('public', $root . "/app/public");
    }
}