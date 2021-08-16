<?php

namespace app\tests;

use app\core\Faker;

use app\tests\ModelTest;
use app\models\Expression;

class ExpressionTest extends ModelTest {
    // Modèle

    public function __construct() {
        $this->model = new Expression();
    }

    // Lancement

    public function launch() {
        $this->log("EXPRESSIONS");

        // Sélection

        $this->call("count");

        $this->call("findAllByTheme", 1);
        $this->call("countByTheme", 1);

        $this->call("findAllByAuthor", 1);
        $this->call("countByAuthor", 1);

        // Insertion

        $data = [
            "french" => Faker::string(),
            "english" => Faker::string(),
            "phonetics" => Faker::string(),
            "user_id" => 1,
            "theme_id" => 1,
        ];

        $this->call("insert", $data);

        // Appartenance

        $this->call("belongsTo", 1, 1);
        $this->call("belongsTo", 2, 1);
        $this->call("belongsTo", 1, 33);

        // Edition

        $new = [
            "french" => "Nouvelle expression",
            "english" => "New expression",
            "phonetics" => "niou éks-pwé-cheu-ne",
            "user_id" => 1,
            "theme_id" => 1,
        ];

        $this->call("update", 1, $new);
        
        // Suppression

        $this->call("delete", 9);
    }
}