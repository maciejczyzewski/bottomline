<?php

namespace __\Test\Collections;

use __;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class ReverseIterableTest extends TestCase
{
    public function testReverseIterableArray()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::reverseIterable($a);

        // Assert
        // Check we got back a Generator.
        $this->assertTrue($x instanceof \Generator);
        $xValues = [];
        foreach ($x as $value) {
            $xValues[] = $value;
        }
        $this->assertEquals([3, 2, 1], $xValues);

        // Note how the keys have been preserved and inverted.
        // TODO Add an option preserve_keys as array_reverse or iterator_to_array?
        $this->assertEquals([2 => 3, 1 => 2, 0 => 1], iterator_to_array(__::reverseIterable($a)));
        $this->assertEquals([3, 2, 1], iterator_to_array(__::reverseIterable($a), false));
    }

    public function testReverseIterableArrayIterable()
    {
        // Arrange
        $a = new ArrayIterator([1, 2, 3]);

        // Act
        $x = __::reverseIterable($a);

        // Assert
        // Check we got back a Generator.
        $this->assertTrue($x instanceof \Generator);
        $xValues = [];
        foreach ($x as $value) {
            $xValues[] = $value;
        }
        $this->assertEquals([3, 2, 1], $xValues);
    }
}
