<?php

namespace __\Test\Functions;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class TruncateTest extends TestCase
{
    public function testTruncate()
    {
        // Arrange
        $a = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et mi orci.';

        // Act
        $x = __::truncate($a, 5);

        // Assert
        $this->assertEquals('Lorem ipsum dolor sit amet, ...', $x);
    }
}
