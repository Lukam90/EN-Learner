<?php

namespace app\validation;

use app\core\Post;

use app\models\Theme;

class ThemeValidation extends Validation {
    private $themeModel;

    // Constructeur

    public function __construct() {
        $this->init();

        $this->themeModel = new Theme();
    }

    // Titre

    public function title() {
        $title = "";

        if (! Post::empty("title")) {
            sleep(1);

            $title = Post::var("title");
    
            if (strlen($title) <= 50) {
                $exists = $this->themeModel->findByTitle($title);
    
                if (! $exists) {
                    $this->unset("title");
                } else {
                    $this->setError("title", "Le thème existe déjà. Veuillez saisir un autre titre.");
                }
            } else {
                $this->setError("title", "Le titre ne doit pas dépasser 50 caractères.");
            }
        } else {
            $this->setError("title", "Le title doit être renseigné.");
        }

        return $title;
    }
}