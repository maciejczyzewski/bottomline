<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class SizeTest extends TestCase
{
    public static function provideSizeCases()
    {
        return [
            [
                'source' => [],
                'expected' => 0,
            ],
            [
                'source' => [1, 2, 3],
                'expected' => 3,
            ],
            [
                'source' => new \stdClass(),
                'expected' => 0,
            ],
            [
                'source' => (object)['hello' => 'world'],
                'expected' => 1,
            ],
            [
                'source' => false,
                'expected' => false,
            ],
            [
                'source' => null,
                'expected' => false,
            ],
            [
                'source' => 3,
                'expected' => false,
            ],
            [
                'source' => new ArrayIterator([]),
                'expected' => 0,
            ],
            [
                'source' => new ArrayIterator([1, 2, 3]),
                'expected' => 3,
            ],
            [
                'source' => new MockIteratorAggregate([]),
                'expected' => 0,
            ],
            [
                'source' => new MockIteratorAggregate([1, 2, 3]),
                'expected' => 3,
            ],
            [
                'source' => call_user_func(function () {
                    yield 1;
                }),
                'expected' => 1,
            ],
            [
                'source' => call_user_func(function () {
                }),
                'expected' => 0,
            ],
        ];
    }

    /**
     * @dataProvider provideSizeCases
     *
     * @param mixed $source
     * @param int   $expected
     */
    public function testSize($source, $expected)
    {
        $this->assertEquals($expected, __::size($source));
    }
}
