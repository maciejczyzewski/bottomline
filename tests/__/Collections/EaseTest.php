<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;

class EaseTest extends \PHPUnit\Framework\TestCase
{
    public static function provideEaseCases()
    {
        $object = new \stdClass();

        return [
            [
                'source' => ['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']],
                'glue' => '.',
                'expected' => ['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z'],
            ],
            [
                'source' => ['foo' => ['bar' => $object], 'baz' => ['b', 'z']],
                'glue' => '_',
                'expected' => ['foo_bar' => $object, 'baz_0' => 'b', 'baz_1' => 'z'],
            ],
            [
                'source' => new ArrayIterator(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]),
                'glue' => '.',
                'expected' => ['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z'],
            ],
            [
                'source' => new MockIteratorAggregate(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]),
                'glue' => '.',
                'expected' => ['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z'],
            ],
            [
                'source' => call_user_func(function () {
                    yield 'foo' => ['bar' => 'ter'];
                    yield 'baz' => ['b', 'z'];
                }),
                'glue' => '.',
                'expected' => ['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z'],
            ],
        ];
    }

    /**
     * @dataProvider provideEaseCases
     *
     * @param mixed  $source
     * @param string $glue
     * @param array  $expected
     */
    public function testEase($source, $glue, $expected)
    {
        $this->assertEquals($expected, __::ease($source, $glue));
    }
}
