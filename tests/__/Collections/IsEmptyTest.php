<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class IsEmptyTest extends TestCase
{
    public function dataProvider_isEmpty()
    {
        return [
            // Assert nominal cases
            [
                'source' => [],
                'expected' => true,
            ],
            [
                'source' => ['Falcon', 'Heavy'],
                'expected' => false,
            ],
            [
                'source' => new \stdClass(),
                'expected' => true,
            ],
            [
                'source' => (object)['Baie' => 'Goji'],
                'expected' => false,
            ],

            // Assert non-collections
            [
                'source' => null,
                'expected' => true,
            ],
            [
                'source' => 3,
                'expected' => true,
            ],
            [
                'source' => true,
                'expected' => true,
            ],


            // Assert iterators
            [
                'source' => new ArrayIterator([]),
                'expected' => true,
            ],
            [
                'source' => new MockIteratorAggregate([]),
                'expected' => true,
            ],
            [
                'source' => new ArrayIterator([1, 2]),
                'expected' => false,
            ],
            [
                'source' => new MockIteratorAggregate([1, 2]),
                'expected' => false,
            ],
            [
                'source' => call_user_func(function () {
                    yield 1;
                    yield 5;
                }),
                'expected' => false,
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_isEmpty
     *
     * @param mixed $source
     * @param bool  $expected
     */
    public function testIsEmpty($source, $expected)
    {
        $this->assertEquals($expected, __::isEmpty($source));
    }
}
