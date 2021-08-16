<?php

namespace app\tests;

use app\core\Faker;

use app\models\User;

use app\tests\ModelTest;

class UserTest extends ModelTest {
    // Modèle

    public function __construct() {
        $this->model = new User();
    }

    // Lancement

    public function launch() {
        $this->log("USERS");

        // Sélection

        $this->call("count");

        $this->call("findAll");

        $this->call("findById", 3);
        $this->call("findById", 44);

        $this->call("findByName", "Lukas");
        $this->call("findByName", "test");

        $this->call("findByEmail", "lukas@admin.com");
        $this->call("findByEmail", "lukas@test.com");

        $this->call("login", "lukas@test.com", "test");
        $this->call("login", "lukas@admin.com", "admin123");
        $this->call("login", "lukas@admin.com", "Admin007");

        // Insertion

        $data = [
            "username" => Faker::string("15"),
            "email" => Faker::email(),
            "password" => Faker::password(),
            "role" => Faker::role()
        ];

        $this->call("insert", $data);

        // Edition

        $this->call("changeUsername", 2, "Bowser");
        $this->call("changeEmail", 2, "bowser@edit.com");
        $this->call("changePassword", 2, "update");
        $this->call("changeRole", 2, "admin");
        $this->call("changeBanStatus", 2, 1);

        // Status

        $this->call("isModerator", 1);
        $this->call("isModerator", 6);
        $this->call("isModerator", 7);

        $this->call("isAdmin", 1);
        $this->call("isAdmin", 6);

        $this->call("isBanned", 1);
        $this->call("isBanned", 2);

        // Suppression

        $this->call("delete", 4);
    }
}