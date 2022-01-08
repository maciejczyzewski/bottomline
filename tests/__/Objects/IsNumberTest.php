<?php

namespace __\Test\Objects;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class IsNumberTest extends TestCase
{    public function testIsNumber()
{
    // Arrange
    $a = 123;

    // Act
    $x = __::isNumber($a);

    // Assert
    $this->assertEquals(true, $x);
}

}
