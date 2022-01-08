<?php

namespace __\Test\Objects;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class IsFunctionTest extends TestCase
{
    public function testIsFunction()
    {
        // Arrange
        $a = function ($a) {
            return $a + 2;
        };

        // Act
        $x = __::isFunction($a);

        // Assert
        $this->assertEquals(true, $x);
    }
}
