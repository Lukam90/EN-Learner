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
}