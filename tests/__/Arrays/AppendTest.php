<?php

namespace __\Test\Arrays;

use __;
use __\Test\Arrays\RepeatTest;

class AppendTest extends \PHPUnit\Framework\TestCase
{
    public function testAppend()
    {
        // Arrange
        $a = [1, 2, 3];
        // Act
        $x = __::append($a, 4);
        $x2 = __::append($a, [4, 5]);
        // Assert
        $this->assertEquals([1, 2, 3, 4], $x);
        $this->assertEquals([1, 2, 3, [4, 5]], $x2);
    }
}
