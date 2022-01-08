<?php

namespace __\Test\Arrays;

use __;
use PHPUnit\Framework\TestCase;

class PrependTest extends TestCase
{
    public function testPrepend()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::prepend($a, 4);

        // Assert
        $this->assertEquals([4, 1, 2, 3], $x);
    }
}
