<?php

namespace __\Test\Arrays;

use __;
use PHPUnit\Framework\TestCase;

class RandomizeTest extends TestCase
{
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
}
