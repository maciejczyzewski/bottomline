<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class UpperFirstTest extends TestCase
{
    public function testUpperFirst()
    {
        // Arrange
        $a = 'fred';
        $b = 'FRED';

        // Act
        $x = __::upperFirst($a);
        $y = __::upperFirst($b);

        // Assert
        $this->assertEquals('Fred', $x);
        $this->assertEquals('FRED', $y);
    }
}
