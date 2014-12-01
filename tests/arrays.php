<?php

class ArraysTest extends PHPUnit_Framework_TestCase
{
    // ...

    public function testAppend()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::append($a, 4);

        // Assert
        $this->assertEquals([1, 2, 3, 4], $x);
    }

    public function testCompact()
    {
        // Arrange
        $a = [0, 1, false, 2, '', 3];

        // Act
        $x = __::compact($a);

        // Assert
        $this->assertEquals([1, 2, 3], $x);
    }

    public function testFlatten()
    {
        // Arrange
        $a  = [1, 2, [3, [4]]];
        $a2 = [1, 2, [3, [[4]]]];

        // Act
        $x  = __::flatten($a);
        $x2 = __::flatten($a2, true);

        // Assert
        $this->assertEquals([1, 2, 3, 4], $x);
        $this->assertEquals([1, 2, 3, [[4]]], $x2);
    }

    public function testPatch()
    {
        // Arrange
        $a = [1, 1, 1, 'contacts' => ['country' => 'US', 'tel' => [123]], 99];
        $p = ['/0' => 2, '/1' => 3, '/contacts/country' => 'CA', '/contacts/tel/0' => 3456];

        // Act
        $x = __::patch($a, $p);

        // Assert
        $this->assertEquals([2, 3, 1, 'contacts' => ['country' => 'CA', 'tel' => [3456]], 99], $x);
    }

    public function testPrepend()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::prepend($a, 4);

        // Assert
        $this->assertEquals([4, 1, 2, 3], $x);
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