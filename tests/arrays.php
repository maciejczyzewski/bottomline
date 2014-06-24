<?php

class ArraysTest extends PHPUnit_Framework_TestCase
{
    // ...

    public function testCompact()
    {
        // Arrange
        $a = [0, 1, false, 2, '', 3];

        // Act
        $x = __::compact($a);

        // Assert
        $this->assertEquals([1, 2, 3], $x);
    }

    public function testGet()
    {
        // Arrange
        $a = ['foo' => ['bar' => 'ter']];

        // Act
        $x = __::get($a, 'foo.bar');

        // Assert
        $this->assertEquals('ter', $x);
    }

    public function testRange()
    {
        // Act
        $x = __::range(5);
        $y = __::range(-2, 2);
        $z = __::range(1, 10, 2);

        // Assert
        $this->assertEquals([1, 2, 3, 4, 5], $x);
        $this->assertEquals([-2, -1, 0, 1, 2], $y);
        $this->assertEquals([1, 3, 5, 7, 9], $z);
    }

    public function testRepeat()
    {
        // Arrange
        $string = 'foo';

        // Act
        $x = __::repeat('foo', 3);

        // Assert
        $this->assertEquals(['foo', 'foo', 'foo'], $x);
    }

    // ...
}