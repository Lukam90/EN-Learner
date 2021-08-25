<?php

namespace app\validation;

use app\core\Post;

use app\models\Expression;

class ExpressionValidation extends Validation {
    private $expressionModel;

    // Constructeur

    public function __construct() {
        $this->init();

        $this->expressionModel = new Expression();
    }

    // Expression (FR)

    public function french() {
        $french = "";

        if (! Post::empty("french")) {
            $title = Post::var("french");

            $this->setTip("french", "L'expression doit être renseignée et contenir jusqu'à 255 caractères.");
    
            if (strlen($french) <= 255) {
                $this->erase("french");
            } else {
                $this->setError("french", "L'expression ne doit pas dépasser 255 caractères.");
            }
        } else {
            $this->setError("french", "L'expression doit être renseignée.");
        }

        return $french;
    }
}