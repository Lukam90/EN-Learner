<?php

namespace app\controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller {
    protected $twig;
    protected $root;

    public function init() {
        $loader = new FilesystemLoader(dirname(__DIR__) . "/public/views");

        $this->twig = new Environment($loader, [
            'cache' => false,
        ]);

        $this->root = "http://localhost/en_app";

        $this->twig->addGlobal('root', $this->root);
        $this->twig->addGlobal('public', $this->root . "/app/public");
    }
}