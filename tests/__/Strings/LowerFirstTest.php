<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class LowerFirstTest extends TestCase
{    public function testLowerFirst()
{
    // Arrange
    $a = 'Fred';
    $b = 'FRED';

    // Act
    $x = __::lowerFirst($a);
    $y = __::lowerFirst($b);

    // Assert
    $this->assertEquals('fred', $x);
    $this->assertEquals('fRED', $y);
}

}
