<?php

namespace __\Test\Objects;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class IsEmailTest extends TestCase
{
    public function testIsEmail()
    {
        // Arrange
        $a = 'test@test.com';

        // Act
        $x = __::isEmail($a);

        // Assert
        $this->assertEquals(true, $x);
    }
}
