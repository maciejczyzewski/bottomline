<?php

namespace __\Test;

use __;
use PHPUnit\Framework\TestCase;

class UtilitiesTest extends TestCase
{
    public function testNow()
    {
        // Act
        $x = __::now();

        // Assert
        $this->assertEquals(true, is_numeric($x));
    }

    public function testIdentity()
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
