<?php

namespace app\tests;

use app\core\Faker;

use app\models\User;

final class UserTest extends ModelTest {
    public function logUser($methodName, $var) {
        $this->log("User", $methodName, $var);
    }

    public function testInit() {
        $res = $this->erase();

        $this->assertNull($res);
    }

    public function testFindAll() {
        $userModel = new User();
        $res = $userModel->findAll();

        $this->logUser(__FUNCTION__, count($res));

        $this->assertNotEmpty($res);
    }

    public function testCount() {
        $userModel = new User();
        $res = $userModel->count();

        $this->logUser(__FUNCTION__, $res);

        $this->assertNotEquals(0, $res);
    }

    public function testFindOneById() {
        $userModel = new User();
        $res = $userModel->findOneById(1);

        $this->logUser(__FUNCTION__, $res->id);

        $this->assertNotNull($res);
    }

    public function testFindOneByName() {
        $userModel = new User();
        $res = $userModel->findOneByName("Lukas");

        $this->logUser(__FUNCTION__, $res->username);

        $this->assertNotNull($res);
    }

    public function testFindOneByEmail() {
        $userModel = new User();
        $res = $userModel->findOneByEmail("lukas@admin.com");

        $this->logUser(__FUNCTION__, $res->email);

        $this->assertNotNull($res);
    }

    public function testFindThemes() {
        $userModel = new User();
        $res = $userModel->findThemes(1);

        $this->logUser(__FUNCTION__, $res[0]->title);

        $this->assertNotNull($res);
    }

    public function testCountThemes() {
        $userModel = new User();
        $res = $userModel->countThemes(1);

        $this->logUser(__FUNCTION__, $res);

        $this->assertIsNumeric($res);
    }

    public function testFindExpressions() {
        $userModel = new User();
        $res = $userModel->findExpressions(1);

        $this->logUser(__FUNCTION__, $res[0]->french);

        $this->assertNotNull($res);
    }

    public function testCountExpressions() {
        $userModel = new User();
        $res = $userModel->countExpressions(1);

        $this->logUser(__FUNCTION__, $res);

        $this->assertIsNumeric($res);
    }

    public function testLogin() {
        $userModel = new User();
        $res = $userModel->login("lukas@admin.com", "Admin007");

        $this->logUser(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testIsModerator() {
        $userModel = new User();
        $res = $userModel->isModerator(7);

        $this->logUser(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testIsAdmin() {
        $userModel = new User();
        $res = $userModel->isAdmin(1);

        $this->logUser(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testIsSuperUser() {
        $userModel = new User();
        $res = $userModel->isSuperUser(1);

        $this->logUser(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testIsBanned() {
        $userModel = new User();
        $res = ! $userModel->isBanned(1);

        $this->logUser(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testInsert() {
        $data = [
            "username" => Faker::string(15),
            "email" => Faker::email(15),
            "password" => Faker::string(10),
            "role" => Faker::role()
        ];

        $userModel = new User();
        $res = $userModel->insert($data);

        $this->logUser(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testChangeUsername() {
        $userModel = new User();

        $res = $userModel->changeUsername(1, "Lukas");

        $this->logUser(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testChangeEmail() {
        $userModel = new User();
        $res = $userModel->changeEmail(1, "lukas@admin.com");

        $this->logUser(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testChangePassword() {
        $userModel = new User();
        $res = $userModel->changePassword(1, "Admin007");

        $this->logUser(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testChangeRole() {
        $userModel = new User();
        $res = $userModel->changeRole(1, "Administrateur");

        $this->logUser(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testChangeBanStatus() {
        $userModel = new User();
        $res = $userModel->changeBanStatus(1, 0);

        $this->logUser(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testDelete() {
        $userModel = new User();
        $res = $userModel->delete(5);

        $this->logUser(__FUNCTION__, $res);

        $this->assertTrue($res);
    }
}