<?php

namespace __\Test\Collections;

use __;

class FindTest extends \PHPUnit\Framework\TestCase
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
            "table"    => "trick",
            "pen"      => "defend",
            "motherly" => "wide",
            "may"      => "needle",
            "sweat"    => "cake",
            "sword"    => "defend",
        ];

        $this->assertEquals("defend", __::find($data, "defend"));
        $this->assertNull(__::find($data, "nonexistent"));
    }

    public function testWithCallback()
    {
        $data = [
            "table"    => (object)["name" => "trick"],
            "pen"      => (object)["name" => "defend"],
            "motherly" => (object)["name" => "wide"],
            "may"      => (object)["name" => "needle"],
            "sweat"    => (object)["name" => "cake"],
            "sword"    => (object)["name" => "defend"],
        ];

        $this->assertEquals($data["pen"], __::find($data, static function ($object) {
            return $object->name === "defend";
        }));
        $this->assertNull(__::find($data, static function ($value) {
            return $value === "potato";
        }));
    }
}
