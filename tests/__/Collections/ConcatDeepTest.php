<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class ConcatDeepTest extends TestCase
{
    public static function dataProvider_concatDeep()
    {
        return [
            [
                'sources' => [
                    ['color' => ['favorite' => 'red', 5], 3],
                    [10, 'color' => ['favorite' => 'green', 'blue']],
                ],
                'expected' => ['color' => ['favorite' => ['red', 'green'], 5, 'blue'], 3, 10],
            ],
            [
                'sources' => [
                    ['a' => 0],
                    ['a' => 1, 'b' => 2],
                    ['c' => 3, 'd' => 4],
                ],
                'expected' => ['a' => [0, 1], 'b' => 2, 'c' => 3, 'd' => 4],
            ],
            [
                'sources' => [
                    (object)['color' => (object)['favorite' => 'red', 5]],
                    (object)[10, 'color' => (object)['favorite' => 'green', 'blue']],
                ],
                'expected' => (object)['color' => (object)['favorite' => ['red', 'green'], 5, 'blue'], 10],
            ],
            [
                'sources' => [
                    (object)['a' => 0],
                    (object)['a' => 1, 'b' => 2],
                    (object)['c' => 3, 'd' => 4],
                ],
                'expected' => (object)['a' => [0, 1], 'b' => 2, 'c' => 3, 'd' => 4],
            ],
            [
                'sources' => [
                    new ArrayIterator(['a' => 0]),
                    new ArrayIterator(['a' => 1, 'b' => 2]),
                    new ArrayIterator(['c' => 3, 'd' => 4]),
                ],
                'expected' => ['a' => [0, 1], 'b' => 2, 'c' => 3, 'd' => 4],
            ],
            [
                'sources' => [
                    new MockIteratorAggregate(['color' => (object)['favorite' => 'red', 5]]),
                    (object)[10, 'color' => (object)['favorite' => 'green', 'blue']],
                ],
                'expected' => ['color' => (object)['favorite' => ['red', 'green'], 5, 'blue'], 10],
            ],
            [
                'sources' => [
                    (object)[],
                    call_user_func(function () {
                        yield 'a' => 0;
                    }),
                    call_user_func(function () {
                        yield 'a' => 1;
                        yield 'b' => 2;
                    }),
                    new ArrayIterator(['c' => 3, 'd' => 4]),
                ],
                'expected' => (object)['a' => [0, 1], 'b' => 2, 'c' => 3, 'd' => 4],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_concatDeep
     *
     * @param array $sources
     * @param array $expected
     */
    public function testConcatDeep($sources, $expected)
    {
        $actual = call_user_func_array('__::concatDeep', $sources);

        $this->assertEquals($expected, $actual);
    }
}
