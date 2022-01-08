<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class CapitalizeTest extends TestCase
{    public function testCapitalize()
{
    // Arrange
    $a = 'FRED';

    // Act
    $x = __::capitalize($a);

    // Assert
    $this->assertEquals('Fred', $x);
}

}
