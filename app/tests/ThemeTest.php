<?php

namespace app\tests;

use app\core\Faker;

use app\models\Theme;

use app\tests\ModelTest;

final class ThemeTest extends ModelTest {
    public function logTheme($methodName, $var) {
        $this->log("Theme", $methodName, $var);
    }

    public function testInit() {
        $res = $this->erase();

        $this->assertNull($res);
    }

    public function testFindAll() {
        $themeModel = new Theme();
        $res = $themeModel->findAll();

        $this->logTheme(__FUNCTION__, count($res));

        $this->assertNotNull($res);
    }

    public function testFindOneById() {
        $themeModel = new Theme();
        $res = $themeModel->findOneById(1);

        $this->logTheme(__FUNCTION__, $res->title);

        $this->assertNotNull($res);
    }

    public function testFindOneByTitle() {
        $themeModel = new Theme();
        $res = $themeModel->findOneByTitle("Expressions de base");

        $this->logTheme(__FUNCTION__, $res->title);

        $this->assertTrue($res);
    }

    public function testCount() {
        $themeModel = new Theme();
        $res = $themeModel->count();

        $this->logTheme(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testFindExpressions() {
        $themeModel = new Theme();
        $res = $themeModel->findExpressions(1);

        $this->logTheme(__FUNCTION__, $res[0]->french);

        $this->assertTrue($res);
    }

    public function testCountExpressions() {
        $themeModel = new Theme();
        $res = $themeModel->countExpressions(1);

        $this->logTheme(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testFindUser() {
        $themeModel = new Theme();
        $res = $themeModel->findUser(1);

        $this->logTheme(__FUNCTION__, $res->username);

        $this->assertTrue($res);
    }

    public function testBelongsTo() {
        $themeModel = new Theme();
        $res = $themeModel->belongsTo(1, 1);

        $this->logTheme(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function test() {
        $themeModel = new Theme();
        $res = $themeModel->();

        $this->logTheme(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function test() {
        $themeModel = new Theme();
        $res = $themeModel->();

        $this->logTheme(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function test() {
        $themeModel = new Theme();
        $res = $themeModel->();

        $this->logTheme(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function test() {
        $themeModel = new Theme();
        $res = $themeModel->();

        $this->logTheme(__FUNCTION__, $res);

        $this->assertTrue($res);
    }
}