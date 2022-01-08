<?php

namespace __\Test\Arrays;

use __;
use PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
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
}
