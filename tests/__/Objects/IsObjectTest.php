<?php

namespace __\Test\Objects;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class IsObjectTest extends TestCase
{
    public function testIsObject()
    {
        // Arrange
        $a = 'fred';

        // Act
        $x = __::isObject($a);

        // Assert
        $this->assertEquals(false, $x);
    }
}
