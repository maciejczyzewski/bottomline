<?php

namespace __\Test\Utilities;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class IdentityTest extends TestCase
{    public function testIdentity()
{
    // Act
    $x = __::identity('arg 1', new \DateTime());

    // Assert
    $this->assertEquals('arg 1', $x);

    // Act
    $x = __::identity();

    // Assert
    $this->assertEquals(null, $x);
}

}
