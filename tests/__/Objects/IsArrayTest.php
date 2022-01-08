<?php

namespace __\Test\Objects;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class IsArrayTest extends TestCase
{
    public function testIsArray()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::isArray($a);

        // Assert
        $this->assertEquals(true, $x);
    }
}
