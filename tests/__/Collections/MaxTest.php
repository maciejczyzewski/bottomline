<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class MaxTest extends TestCase
{
    public function testMax()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::max($a);

        // Assert
        $this->assertEquals(3, $x);
    }

    public function testMaxIterable()
    {
        // Arrange
        $a = new ArrayIterator([1, 2, 3]);

        // Act
        $x = __::max($a);

        // Assert
        $this->assertEquals(3, $x);
    }
}
