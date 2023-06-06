<?php

namespace __\Test\Collections;

use __;
use PHPUnit\Framework\TestCase;

class EveryTest extends TestCase
{
    public static function provideEveryCases()
    {
        return [
            [
                'description' => "Passing an array with one or more non-bool values should return false when given a callback to check for booleans",
                'actual' => [true, 1, null, 'yes'],
                'callback' => static function ($v) {
                    return is_bool($v);
                },
                'expected' => false,
            ],
            [
                'description' => "Passing an array with only booleans should return true when given a callback to check for booleans",
                'actual' => [true, false],
                'callback' => static function ($v) {
                    return is_bool($v);
                },
                'expected' => true,
            ],
            [
                'description' => "Passing an array with only integers should return true when given a callback to check for integers",
                'actual' => [1, 3, 4],
                'callback' => static function ($v) {
                    return is_int($v);
                },
                'expected' => true,
            ],
            [
                'description' => "Passing an array with truthy values should return true when given null as the callback",
                'actual' => [1, "hello", true],
                'callback' => null,
                'expected' => true,
            ],
        ];
    }

    /**
     * @dataProvider provideEveryCases
     */
    public function testEvery($message, $actual, $callback, $expected)
    {
        $actual = __::every($actual, $callback);

        $this->assertSame($expected, $actual, $message);
    }
}
