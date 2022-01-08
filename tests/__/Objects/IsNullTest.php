<?php

namespace __\Test\Objects;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class IsNullTest extends TestCase
{
    public function testIsNull()
    {
        // Arrange
        $a = null;

        // Act
        $x = __::isNull($a);

        // Assert
        $this->assertEquals(true, $x);
    }
}
