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

    // Général

    public function check($field, $label) {
        $res = "";

        if (! Post::empty($field)) {
            $res = Post::var($field);

            $this->setTip($field, "$label doit être renseignée et contenir jusqu'à 255 caractères.");
    
            if (strlen($res) <= 255) {
                $this->erase($field);
            } else {
                $this->setError($field, "$label ne doit pas dépasser 255 caractères.");
            }
        } else {
            $this->setError($field, "$label doit être renseignée.");
        }

        return $res;
    }

    // Expression (FR)

    public function checkFrench() {
        $french = $this->check("french", "L'expression");

        return $french;
    }

    // Traduction (EN)

    public function checkEnglish() {
        $english = $this->check("english", "La traduction");

        return $english;
    }

    // Transcription phonétique

    public function checkPhonetics() {
        $phonetics = $this->check("phonetics", "La transcription phonétique");

        return $phonetics;
    }
}