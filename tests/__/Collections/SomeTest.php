<?php

namespace __\Test\Collections;

use __;
use PHPUnit\Framework\TestCase;

class SomeTest extends TestCase
{
    public static function provideSameCases()
    {
        return [
            [
                'description' => "Having at least one even number should return true",
                'actual' => [1, 3, 5, 10, 7, 9],
                'callback' => static function ($item) {
                    return $item % 2 === 0;
                },
                'expected' => true
            ],
            [
                'description' => "Having no even numbers should return false",
                'actual' => [1, 3, 5, 7, 9],
                'callback' => static function ($item) {
                    return $item % 2 === 0;
                },
                'expected' => false
            ],
            [
                'description' => "Having at least one truthy value should return true",
                'actual' => [false, [], 1],
                'callback' => null,
                'expected' => true
            ],
            [
                'description' => "Having all falsey values should return false",
                'actual' => [false, [], 0],
                'callback' => null,
                'expected' => false
            ],
        ];
    }

    /**
     * @dataProvider provideSameCases
     */
    public function testSame($message, $actual, $callback, $expected)
    {
        $actual = __::some($actual, $callback);

        $this->assertSame($expected, $actual, $message);
    }
}
