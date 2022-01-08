<?php

namespace __\Test\Arrays;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class FlattenTest extends TestCase
{
    public static function dataProvider_flatten()
    {
        $object = (object)[10, 11, 12];

        return [
            [
                'source' => [1, 2, [3, [4]]],
                'shallow' => false,
                'isGenerator' => false,
                'expected' => [1, 2, 3, 4],
            ],
            [
                'source' => [1, 2, [3, $object]],
                'shallow' => false,
                'isGenerator' => false,
                'expected' => [1, 2, 3, $object],
            ],
            [
                'source' => [1, 2, [3, [$object]]],
                'shallow' => true,
                'isGenerator' => false,
                'expected' => [1, 2, 3, [$object]],
            ],
            [
                'source' => [1, 2, [3, [[4]]]],
                'shallow' => true,
                'isGenerator' => false,
                'expected' => [1, 2, 3, [[4]]],
            ],
            [
                'source' => new ArrayIterator([1, 2, [3, [[4]]]]),
                'shallow' => false,
                'isGenerator' => true,
                'expected' => [1, 2, 3, 4],
            ],
            [
                'source' => new MockIteratorAggregate([1, 2, [3, [[4]]]]),
                'shallow' => false,
                'isGenerator' => true,
                'expected' => [1, 2, 3, 4],
            ],
            [
                'source' => new ArrayIterator([
                    1,
                    2,
                    new ArrayIterator([3, [[4]]]),
                ]),
                'shallow' => false,
                'isGenerator' => true,
                'expected' => [1, 2, 3, 4],
            ],
            [
                'source' => call_user_func(function () {
                    yield 1;
                    yield 2;
                    yield call_user_func(function () {
                        yield 3;
                        yield [[[4]]];
                    });
                }),
                'shallow' => false,
                'isGenerator' => true,
                'expected' => [1, 2, 3, 4],
            ],
            [
                'source' => call_user_func(function () {
                    yield 1;
                    yield 2;
                    yield call_user_func(function () {
                        yield [3];
                        yield [[[4]]];
                    });
                }),
                'shallow' => true,
                'isGenerator' => true,
                'expected' => [1, 2, [3], [[[4]]]],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_flatten
     *
     * @param array $source
     * @param bool  $shallow
     * @param bool  $isGenerator
     * @param array $expected
     */
    public function testFlatten($source, $shallow, $isGenerator, $expected)
    {
        $actual = __::flatten($source, $shallow);

        if ($isGenerator) {
            $this->assertInstanceOf(\Generator::class, $actual);
        } else {
            $this->assertTrue(is_array($actual));
        }

        foreach ($actual as $i => $value) {
            $this->assertEquals($expected[$i], $value);
        }
    }
}
