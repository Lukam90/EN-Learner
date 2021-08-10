<?php

namespace app\tests;

use app\core\Faker;

use app\models\Theme;
use app\tests\ModelTest;

class ThemeTest extends ModelTest {
    // Modèle

    public function __construct() {
        $this->model = new Theme();
    }

    // Lancement

    public function launch() {
        $this->log("THEMES");

        // Sélection

        $this->call("count");

        $this->call("findById", 1);
        $this->call("findById", 24);

        $this->call("findByTitle", "Jours de la semaine");
        $this->call("findByTitle", "Inconnu");

        $this->call("findAllByUser", 1);
        $this->call("countByUser", 1);

        $this->call("findAllByUser", 5);
        $this->call("countByUser", 5);

        // Insertion

        $data = [
            "title" => Faker::string(),
            "user_id" => 1,
        ];

        $this->call("insert", $data);

        // Appartenance

        $this->call("belongsTo", 1, 1);
        $this->call("belongsTo", 2, 1);
        $this->call("belongsTo", 1, 4);

        // Edition

        $this->call("update", 1, ["title" => "Mon nouveau titre"]);

        // Suppression

        $this->call("delete", 3);
    }
}