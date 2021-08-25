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
            $french = Post::var("french");

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

    // Traduction (EN)

    public function english() {
        $english = "";

        if (! Post::empty("english")) {
            $english = Post::var("english");

            $this->setTip("english", "La traduction doit être renseignée et contenir jusqu'à 255 caractères.");
    
            if (strlen($english) <= 255) {
                $this->erase("english");
            } else {
                $this->setError("english", "La traduction ne doit pas dépasser 255 caractères.");
            }
        } else {
            $this->setError("english", "La traduction doit être renseignée.");
        }

        return $english;
    }

    // Transcription phonétique

    public function phonetics() {
        $phonetics = "";
    
        if (! Post::empty("phonetics")) {
            $phonetics = Post::var("phonetics");
    
            $this->setTip("phonetics", "La transcription phonétique doit être renseignée et contenir jusqu'à 255 caractères.");
    
            if (strlen($phonetics) <= 255) {
                $this->erase("phonetics");
            } else {
                $this->setError("phonetics", "La transcription phonétique ne doit pas dépasser 255 caractères.");
            }
        } else {
            $this->setError("phonetics", "La transcription phonétique doit être renseignée.");
        }
    
        return $phonetics;
    }
}