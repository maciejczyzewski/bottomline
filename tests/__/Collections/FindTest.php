<?php

namespace __\Test\Collections;

use __;

class FindTest extends \PHPUnit_Framework_TestCase
{
    public function testWithNumericalKeyArray()
    {
        $data = ["native", "pale", "explain", "persuade", "elastic"];

        $this->assertEquals("explain", __::find($data, "explain"));
        $this->assertNull(__::find($data, "nonexistent"));
    }

    public function testWithAssociativeArray()
    {
        $data = [
            "table" => "trick",
            "pen" => "defend",
            "motherly" => "wide",
            "may" => "needle",
            "sweat" => "cake",
        ];

        $this->assertEquals("defend", __::find($data, "defend"));
        $this->assertNull(__::find($data, "nonexistent"));
    }

    public function testWithCallback()
    {
        $data = [
            "table" => (object)["value" => "trick"],
            "pen" => (object)["value" => "defend"],
            "motherly" => (object)["value" => "wide"],
            "may" => (object)["value" => "needle"],
            "sweat" => (object)["value" => "cake"],
            "sword" => (object)["value" => "defend"],
        ];

        $this->assertEquals($data["pen"], __::find($data, static function ($object) {
            return $object->value === "defend";
        }));
        $this->assertNull(__::find($data, static function ($value) {
            return $value === "potato";
        }));
    }
}
