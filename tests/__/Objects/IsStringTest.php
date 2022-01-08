<?php

namespace __\Test\Objects;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class IsStringTest extends TestCase
{
    public function testIsString()
    {
        // Arrange
        $a = 'fred';

        // Act
        $x = __::isString($a);

        // Assert
        $this->assertEquals(true, $x);
    }
}
