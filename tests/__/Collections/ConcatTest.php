<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use PHPUnit\Framework\TestCase;
use ArrayIterator;

class ConcatTest extends TestCase
{
    public static function provideConcatCases()
    {
        return [
            // Test with multiple arrays should return an array
            [
                'sources' => [
                    ['color' => ['favorite' => 'red', 5], 3],
                    [10, 'color' => ['favorite' => 'green', 'blue']],
                ],
                'expected' => ['color' => ['favorite' => 'green', 'blue'], 3, 10],
            ],
            // Test with multiple objects should return an object
            [
                'sources' => [
                    (object)['color' => (object)['favorite' => 'red', 5]],
                    (object)[10, 'color' => (object)['favorite' => 'green', 'blue']],
                ],
                'expected' => (object)['color' => (object)['favorite' => 'green', 'blue'], 10],
            ],
            // Test three objects returns an object
            [
                'sources' => [
                    (object)['a' => 0],
                    (object)['a' => 1, 'b' => 2],
                    (object)['c' => 3, 'd' => 4],
                ],
                'expected' => (object)['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4],
            ],
            // Test arrays and objects mixing together, returns array because 1st element is array
            [
                'sources' => [
                    ['a' => 0],
                    (object)['a' => 1, 'b' => 2],
                    (object)['c' => 3, 'd' => 4],
                ],
                'expected' => ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4],
            ],
            // Test arrays and objects mixing together, returns object because 1st element is object
            [
                'sources' => [
                    (object)['a' => 0],
                    ['a' => 1, 'b' => 2],
                    ['c' => 3, 'd' => 4],
                ],
                'expected' => (object)['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4],
            ],
            [
                'sources' => [
                    ['a' => 0],
                    ['a' => 1, 'b' => 2, 5],
                    ['c' => 3, 'd' => 4, 6],
                ],
                'expected' => ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 5, 6],
            ],
            // Test concat with arrays and iterables
            [
                'sources' => [
                    ['a' => 0],
                    new ArrayIterator(['a' => 1, 'b' => 2, 5]),
                    new MockIteratorAggregate(['c' => 3, 'd' => 4, 6]),
                ],
                'expected' => ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 5, 6],
            ],
            // Test on arrays with no keys just append
            [
                'sources' => [
                    [1, 2, 3],
                    [4, 5],
                ],
                'expected' => [1, 2, 3, 4, 5],
            ],
            // Test iterator with an array
            [
                'sources' => [
                    new ArrayIterator([1, 2, 3]),
                    [4, 5],
                ],
                'expected' => [1, 2, 3, 4, 5],
            ],
            [
                'sources' => [
                    new MockIteratorAggregate([1, 2, 3]),
                    (object)[4, 5],
                ],
                'expected' => [1, 2, 3, 4, 5],
            ],
            // Test generator and array
            [
                'sources' => [
                    call_user_func(function () {
                        yield 1;
                        yield 2;
                        yield 3;
                    }),
                    [4, 5, 6],
                ],
                'expected' => [1, 2, 3, 4, 5, 6],
            ],
            // Test all generators
            [
                'sources' => [
                    call_user_func(function () {
                        yield 1;
                        yield 2;
                        yield 3;
                    }),
                    call_user_func(function () {
                        yield 4;
                        yield 5;
                        yield 6;
                    }),
                    call_user_func(function () {
                        yield 7;
                        yield 8;
                        yield 9;
                    }),
                ],
                'expected' => [1, 2, 3, 4, 5, 6, 7, 8, 9],
            ],
        ];
    }

    /**
     * @dataProvider provideConcatCases
     *
     * @param array $sources
     * @param array $expected
     */
    public function testConcat($sources, $expected)
    {
        $actual = call_user_func_array('__::concat', $sources);

        $this->assertEquals($expected, $actual);
    }
}
