<?php

namespace __\Test\Collections;

use __;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class UneaseTest extends TestCase
{
    public function testUnease()
    {
        // Arrange
        $a = ['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z'];

        // Act
        $x = __::unease($a);

        // Assert
        $this->assertCount(2, $x);
        $this->assertEquals(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']], $x);
    }

    public function testUneaseIterable()
    {
        // Arrange
        $a = new ArrayIterator(['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z']);

        // Act
        $x = __::unease($a);

        // Assert
        $this->assertCount(2, $x);
        $this->assertEquals(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']], $x);
    }
}
