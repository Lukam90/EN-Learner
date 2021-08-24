<?php

namespace app\validation;

abstract class Validation {
    protected $tips;
    protected $errors;

    /**
     * Main constructor
     */

    public function init() {
        $this->tips = [];
        $this->errors = [];
    }

    /**
     * Get tips
     */

    public function getTips() {
        return $this->tips;
    }

    /**
     * Set tip
     */

    public function setTip($name, $message) {
        $this->tips[$name] = $message;
    }

    /**
     * Get error messages
     */

    public function getErrors() {
        return $this->errors;
    }

    /**
     * Set error message
     */

    public function setError($name, $message) {
        $this->errors[$name] = $message;
    }

    /**
     * Erase tips and error messages
     */

    public function erase($attribute) {
        $this->setTip($attribute, "");
        $this->setError($attribute, "");
    }
}