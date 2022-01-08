<?php

namespace __\Test\Arrays;

use __;
use PHPUnit\Framework\TestCase;

class RepeatTest extends TestCase
{
    public function testRepeat()
    {
        // Arrange
        $string = 'foo';

        // Act
        $x = __::repeat($string, 3);

        // Assert
        $this->assertEquals([$string, $string, $string], $x);
    }
}
