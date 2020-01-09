<?php

namespace __\Test;

use __;
use __\Test\Utilities\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class ArraysTest extends TestCase
{
    public function testAppend()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::append($a, 4);
        $x2 = __::append($a, [4, 5]);

        // Assert
        $this->assertEquals([1, 2, 3, 4], $x);
        $this->assertEquals([1, 2, 3, [4, 5]], $x2);
    }

    public static function dataProvider_chunk()
    {
        return [
            [
                'sourceArray' => [1, 2, 3, 4, 5],
                'chunkSize' => 3,
                'preserveKeys' => false,
                'expectedChunks' => [
                    [1, 2, 3],
                    [4, 5],
                ],
            ],
            [
                'sourceArray' => [1],
                'chunkSize' => 3,
                'preserveKeys' => false,
                'expectedChunks' => [
                    [1],
                ],
            ],
            [
                'sourceArray' => [
                    'a' => 1,
                    'b' => 2,
                    'c' => 3,
                    'd' => 4,
                    'e' => 5,
                ],
                'chunkSize' => 2,
                'preserveKeys' => true,
                'expectedChunks' => [
                    [
                        'a' => 1,
                        'b' => 2,
                    ],
                    [
                        'c' => 3,
                        'd' => 4,
                    ],
                    [
                        'e' => 5,
                    ],
                ],
            ],
            [
                'sourceArray' => new MockIteratorAggregate([1, 2, 3, 4, 5]),
                'chunkSize' => 3,
                'preserveKeys' => false,
                'expectedChunks' => [
                    [1, 2, 3],
                    [4, 5],
                ],
            ],
            [
                'sourceArray' => call_user_func(function () {
                    yield 1;
                    yield 2;
                    yield 3;
                    yield 4;
                    yield 5;
                }),
                'chunkSize' => 3,
                'preserveKeys' => false,
                'expectedChunks' => [
                    [1, 2, 3],
                    [4, 5],
                ],
            ],
            [
                'sourceArray' => new ArrayIterator([1, 2, 3, 4, 5]),
                'chunkSize' => 3,
                'preserveKeys' => false,
                'expectedChunks' => [
                    [1, 2, 3],
                    [4, 5],
                ],
            ],
            [
                'sourceArray' => new ArrayIterator([
                    'a' => 1,
                    'b' => 2,
                    'c' => 3,
                    'd' => 4,
                    'e' => 5,
                ]),
                'chunkSize' => 2,
                'preserveKeys' => true,
                'expectedChunks' => [
                    [
                        'a' => 1,
                        'b' => 2,
                    ],
                    [
                        'c' => 3,
                        'd' => 4,
                    ],
                    [
                        'e' => 5,
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_chunk
     *
     * @param array|\Traversable $sourceArray
     * @param int                $chunkSize
     * @param bool               $preserveKeys
     * @param array              $expectedChunks
     */
    public function testChunk($sourceArray, $chunkSize, $preserveKeys, $expectedChunks)
    {
        $actual = __::chunk($sourceArray, $chunkSize, $preserveKeys);

        foreach ($actual as $i => $chunk) {
            $this->assertEquals($expectedChunks[$i], $chunk);
        }
    }

    public static function dataProvider_compact()
    {
        return [
            [
                'sourceArray' => [0, 1, false, 2, '', 3],
                'expected' => [1, 2, 3],
            ],
            [
                'sourceArray' => new ArrayIterator([0, 1, false, 2, '', 3]),
                'expected' => [1, 2, 3],
            ],
            [
                'sourceArray' => new MockIteratorAggregate([0, 1, false, 2, '', 3]),
                'expected' => [1, 2, 3],
            ],
            [
                'sourceArray' => call_user_func(function () {
                    yield 0;
                    yield 1;
                    yield false;
                    yield 2;
                    yield '';
                    yield 3;
                }),
                'expected' => [1, 2, 3],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_compact
     *
     * @param array|iterable $sourceArray
     * @param array          $expected
     */
    public function testCompact($sourceArray, $expected)
    {
        $actual = __::compact($sourceArray);

        foreach ($actual as $i => $item) {
            $this->assertEquals($expected[$i], $item);
        }
    }

    public function testDrop()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::drop($a);
        $y = __::drop($a, 2);
        $z = __::drop($a, 5);
        $xa = __::drop($a, 0);

        // Assert
        $this->assertEquals([2, 3], $x);
        $this->assertEquals([3], $y);
        $this->assertEquals([], $z);
        $this->assertEquals([1, 2, 3], $xa);
    }

    public function testDropWithIterator()
    {
        $a = [1, 2, 3, 4, 5];
        $aItr = new ArrayIterator($a);

        $expected = __::drop($a, 3);
        $actual = __::drop($aItr, 3);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }

    public function testDropWithIteratorAggregate()
    {
        $a = [1, 2, 3, 4, 5];
        $aItrAgg = new MockIteratorAggregate($a);

        $expected = __::drop($a, 3);
        $actual = __::drop($aItrAgg, 3);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }

    public function testDropWithGenerator()
    {
        $a = [1, 2, 3, 4, 5];
        $generator = call_user_func(function () use ($a) {
            foreach ($a as $item) {
                yield $item;
            }
        });

        $this->assertInstanceOf(\Generator::class, $generator);

        $expected = __::drop($a, 3);
        $actual = __::drop($generator, 3);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }

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

    public function testPatch()
    {
        // Arrange
        $a = [1, 1, 1, 'contacts' => ['country' => 'US', 'tel' => [123]], 99];
        $p = ['/0' => 2, '/1' => 3, '/contacts/country' => 'CA', '/contacts/tel/0' => 3456];

        // Act
        $x = __::patch($a, $p);

        // Assert
        $this->assertEquals([2, 3, 1, 'contacts' => ['country' => 'CA', 'tel' => [3456]], 99], $x);
    }

    public function testPrepend()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::prepend($a, 4);

        // Assert
        $this->assertEquals([4, 1, 2, 3], $x);
    }

    public function testRandomize()
    {
        // Arrange
        $a = [1, 2, 3, 4];
        $b = [1];
        $c = [1, 2];
        $d = [];

        // Act
        $x = __::randomize($a);
        $y = __::randomize($b);
        $z = __::randomize($c);
        $f = __::randomize($d);

        // Assert
        $this->assertNotEquals([1, 2, 3, 4], $x);
        $this->assertEquals([1], $y);
        $this->assertEquals([2, 1], $z);
        $this->assertEquals([], $f);
    }

    public function testRange()
    {
        // Act
        $x = __::range(5);
        $y = __::range(-2, 2);
        $z = __::range(1, 10, 2);

        // Assert
        $this->assertEquals([1, 2, 3, 4, 5], $x);
        $this->assertEquals([-2, -1, 0, 1, 2], $y);
        $this->assertEquals([1, 3, 5, 7, 9], $z);
    }

    public function testRepeat()
    {
        // Arrange
        $string = 'foo';

        // Act
        $x = __::repeat($string, 3);

        // Assert
        $this->assertEquals([$string, $string, $string], $x);
    }
}
