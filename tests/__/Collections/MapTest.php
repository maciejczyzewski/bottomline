<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{
    public static function dataProvider_map()
    {
        return [
            [
                'source' => [1, 2, 3],
                'closure' => function ($n) {
                    return $n * 3;
                },
                'isGenerator' => false,
                'expected' => [3, 6, 9],
            ],
            [
                'source' => (object)['a' => 1, 'b' => 2, 'c' => 3],
                'closure' => function ($n, $key) {
                    return $key === 'c' ? $n : $n * 3;
                },
                'isGenerator' => false,
                'expected' => [3, 6, 3],
            ],
            [
                'source' => new ArrayIterator([1, 2, 3]),
                'closure' => function ($n) {
                    return $n * 3;
                },
                'isGenerator' => true,
                'expected' => [3, 6, 9],
            ],
            [
                'source' => new MockIteratorAggregate([1, 2, 3]),
                'closure' => function ($n) {
                    return $n * 6;
                },
                'isGenerator' => true,
                'expected' => [6, 12, 18],
            ],
            [
                'source' => call_user_func(function () {
                    yield 1;
                    yield 2;
                    yield 3;
                }),
                'closure' => function ($n) {
                    return $n * 3;
                },
                'isGenerator' => true,
                'expected' => [3, 6, 9],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_map
     *
     * @param iterable $source
     * @param \Closure $closure
     * @param bool     $isGenerator
     * @param array    $expected
     */
    public function testMap($source, $closure, $isGenerator, $expected)
    {
        $actual = __::map($source, $closure);

        if ($isGenerator) {
            $this->assertInstanceOf(\Generator::class, $actual);
        } else {
            $this->assertTrue(is_array($actual));
        }

        foreach ($actual as $key => $value) {
            $this->assertEquals($expected[$key], $value);
        }
    }
}
