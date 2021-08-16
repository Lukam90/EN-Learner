<?php

namespace app\core;

use app\models\User;

abstract class Validation {
    protected $tips;
    protected $errors;

    // Base des constructeurs

    public function init() {
        $this->tips = [];
        $this->errors = [];
    }

    // Indications

    public function getTips() {
        return $this->tips;
    }

    public function setTip($name, $message) {
        $this->tips[$name] = $message;
    }

    // Erreurs

    public function getErrors() {
        return $this->errors;
    }

    public function setError($name, $message) {
        $this->errors[$name] = $message;
    }
}