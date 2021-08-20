<?php

namespace app\tests;

use app\core\Faker;

use app\models\Theme;

use app\tests\ModelTest;

final class ThemeTest extends ModelTest {
    public function logTheme($methodName, $var) {
        $this->log("Theme", $methodName, $var);
    }

    public function testFindAll() {
        $themeModel = new Theme();
        $res = $themeModel->findAll();

        $this->logTheme(__FUNCTION__, count($res));

        $this->assertNotEmpty($res);
    }

    public function testFindOneById() {
        $themeModel = new Theme();
        $res = $themeModel->findOneById(1);

        $this->logTheme(__FUNCTION__, $res->title);

        $this->assertNotEmpty($res);
    }

    public function testFindOneByTitle() {
        $themeModel = new Theme();
        $res = $themeModel->findOneByTitle("Expressions de base");

        $this->logTheme(__FUNCTION__, $res->title);

        $this->assertNotEmpty($res);
    }

    public function testCount() {
        $themeModel = new Theme();
        $res = $themeModel->count();

        $this->logTheme(__FUNCTION__, $res);

        $this->assertNotEmpty($res);
    }

    public function testFindExpressions() {
        $themeModel = new Theme();
        $res = $themeModel->findExpressions(1);

        $this->logTheme(__FUNCTION__, $res[0]->french);

        $this->assertNotEmpty($res);
    }

    public function testNotFindExpressions() {
        $themeModel = new Theme();
        $res = $themeModel->findExpressions(14);

        $this->assertEmpty($res);
    }

    public function testCountExpressions() {
        $themeModel = new Theme();
        $res = $themeModel->countExpressions(1);

        $this->logTheme(__FUNCTION__, $res);

        $this->assertNotEquals(0, $res);
    }

    public function testFindUser() {
        $themeModel = new Theme();
        $res = $themeModel->findUser(1);

        $this->logTheme(__FUNCTION__, $res->username);

        $this->assertNotEmpty($res);
    }

    public function testBelongsTo() {
        $themeModel = new Theme();
        $res = $themeModel->belongsTo(1, 1);

        $this->logTheme(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testInsert() {
        $data = [
            "title" => Faker::string(10),
            "user_id" => 1
        ];

        $themeModel = new Theme();
        $res = $themeModel->insert($data);

        $this->logTheme(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testUpdate() {
        $themeModel = new Theme();
        $res = $themeModel->update(1, "Expressions de base");

        $this->logTheme(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testDelete() {
        $themeModel = new Theme();
        $res = $themeModel->delete(4);

        $this->logTheme(__FUNCTION__, $res);

        $this->assertTrue($res);
    }
}