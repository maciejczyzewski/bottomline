<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class MinTest extends TestCase
{
    public function testMin()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::min($a);

        // Assert
        $this->assertEquals(1, $x);
    }

    public function testMinIterable()
    {
        // Arrange
        $a = new ArrayIterator([1, 2, 3]);

        // Act
        $x = __::min($a);

        // Assert
        $this->assertEquals(1, $x);
    }
}
