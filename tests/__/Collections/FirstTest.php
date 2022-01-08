<?php

namespace __\Test\Collections;

use __;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
    public function testFirst()
    {
        // Arrange
        $a = [1, 2, 3, 4, 5];

        // Act
        $x = __::first($a);
        $y = __::first($a, 2);

        // Assert
        $this->assertEquals(1, $x);
        $this->assertEquals([1, 2], $y);
    }

    public function testFirstIterable()
    {
        if (version_compare(PHP_VERSION, '7.1', '<')) {
            return;
        }
        // Arrange
        $a = new ArrayIterator([1, 2, 3, 4, 5]);

        // Act
        $x = __::first($a);
        $y = __::first($a, 2);

        // Assert
        $this->assertEquals(1, $x);
        $this->assertEquals([1, 2], $y);
    }
}
