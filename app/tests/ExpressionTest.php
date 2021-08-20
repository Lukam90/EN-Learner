<?php

namespace app\tests;

use app\core\Faker;

use app\models\Expression;

class ExpressionTest extends ModelTest {
    public function logExpression($methodName, $var) {
        $this->log("Expression", $methodName, $var);
    }

    public function testFindAll() {
        $expressionModel = new Expression();
        $res = $expressionModel->findAll();

        $this->logExpression(__FUNCTION__, count($res));

        $this->assertNotEmpty($res);
    }

    public function testFindOneById() {
        $expressionModel = new Expression();
        $res = $expressionModel->findOneById(1);

        $this->logExpression(__FUNCTION__, $res->french);

        $this->assertNotEmpty($res);
    }

    public function testCount() {
        $expressionModel = new Expression();
        $res = $expressionModel->count();

        $this->logExpression(__FUNCTION__, $res);

        $this->assertNotEquals(0, $res);
    }

    public function testBelongsTo() {
        $expressionModel = new Expression();
        $res = $expressionModel->belongsTo(1,1);

        $this->logExpression(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testInsert() {
        $data = [
            "french" => Faker::string(),
            "english" => Faker::string(),
            "phonetics" => Faker::string(),
            "theme_id" => 1,
            "user_id" => 1
        ];

        $expressionModel = new Expression();
        $res = $expressionModel->insert($data);

        $this->logExpression(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testUpdate() {
        $data = [
            "french" => "Bonjour ! (le matin)",
            "english" => "Good morning !",
            "phonetics" => "goud mor-ning",
        ];

        $expressionModel = new Expression();
        $res = $expressionModel->update(1, $data);

        $this->logExpression(__FUNCTION__, $res);

        $this->assertTrue($res);
    }

    public function testDelete() {
        $expressionModel = new Expression();
        $res = $expressionModel->delete(11);

        $this->logExpression(__FUNCTION__, $res);

        $this->assertTrue($res);
    }
}