<?php

namespace __\Test\Arrays;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class CompactTest extends TestCase
{
    public static function provideCompactCases()
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
     * @dataProvider provideCompactCases
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
}
