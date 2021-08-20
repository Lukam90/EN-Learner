<?php

namespace app\validation;

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

    // Suppression des indications et des erreurs

    public function erase($attribute) {
        $this->setTip($attribute, "");
        $this->setError($attribute, "");
    }
}