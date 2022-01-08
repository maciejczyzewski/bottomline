<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class LastTest extends TestCase
{
    public static function dataProvider_last()
    {
        return [
            [
                'source' => [1, 2, 3, 4, 5],
                'take' => 2,
                'expected' => [4, 5],
            ],
            [
                'source' => [1, 2, 3, 4, 5],
                'take' => null,
                'expected' => 5,
            ],
            [
                'source' => new MockIteratorAggregate([1, 2, 3, 4, 5]),
                'take' => 3,
                'expected' => [3, 4, 5],
            ],
            [
                'source' => new ArrayIterator([1, 2, 3, 4, 5]),
                'take' => 4,
                'expected' => [2, 3, 4, 5],
            ],
            [
                'source' => call_user_func(function () {
                    yield 1;
                    yield 2;
                    yield 3;
                    yield 4;
                    yield 5;
                }),
                'take' => 2,
                'expected' => [4, 5],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_last
     *
     * @param iterable $source
     * @param int|null $take
     * @param array    $expected
     */
    public function testLast($source, $take, $expected)
    {
        $actual = __::last($source, $take);

        $this->assertEquals($expected, $actual);
    }
}
