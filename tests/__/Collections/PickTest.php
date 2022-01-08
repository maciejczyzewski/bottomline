<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class PickTest extends TestCase
{
    public function testPick()
    {
        // Arrange
        $a = ['a' => 1, 'b' => ['c' => 3, 'd' => 4], 'h' => 5];

        // Act
        $x = __::pick($a, ['a', 'b.d', 'e', 'f.g']);

        // Assert
        $this->assertEquals([
            'a' => 1,
            'b' => ['d' => 4],
            'e' => null,
            'f' => ['g' => null]
        ], $x);
    }

    public function testPickDefaults()
    {
        // Arrange.
        $a = ['nasa' => 1, 'cnsa' => 42];
        $b = ['a' => 1, 'b' => ['c' => 3, 'd' => 4]];

        // Act.
        $x = __::pick($a, ['cnsa', 'esa', 'jaxa'], 26);
        $y = __::pick($b, ['a', 'b.d', 'e', 'f.g'], 'default');

        // Assert.
        $this->assertEquals([
            'cnsa' => 42,
            'esa' => 26,
            'jaxa' => 26,
        ], $x);
        $this->assertEquals([
            'a' => 1,
            'b' => ['d' => 4],
            'e' => 'default',
            'f' => ['g' => 'default']
        ], $y);
    }

    public function testPickObject()
    {
        // Arrange.
        $a = new \stdClass();
        $a->paris = 10659489;
        $a->marseille = 1578484;
        $a->lyon = 1620331;

        // Act.
        $x = __::pick($a, ['marseille', 'london']);

        // Assert.
        $this->assertEquals((object)[
            'marseille' => 1578484,
            'london' => null
        ], $x);
    }

    public function testPickIterable()
    {
        // Arrange
        $a = new ArrayIterator(['a' => 1, 'b' => ['c' => 3, 'd' => 4], 'h' => 5]);

        // Act
        $x = __::pick($a, ['a', 'b.d', 'e', 'f.g']);

        // Assert
        $this->assertEquals([
            'a' => 1,
            'b' => ['d' => 4],
            'e' => null,
            'f' => ['g' => null]
        ], $x);
    }
}
