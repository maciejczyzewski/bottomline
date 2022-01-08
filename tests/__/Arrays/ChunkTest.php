<?php

namespace __\Test\Arrays;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class ChunkTest extends TestCase
{
    public static function provideChunkCases()
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
     * @dataProvider provideChunkCases
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
}
