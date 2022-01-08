<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class MergeTest extends TestCase
{
    public function testMerge()
    {
        // Arrange
        $a1 = ['color' => ['favorite' => 'red', 'model' => 3, 5], 3];
        $a2 = [10, 'color' => ['favorite' => 'green', 'blue']];
        $b1 = ['a' => 0];
        $b2 = ['a' => 1, 'b' => 2];
        $b3 = ['c' => 3, 'd' => 4];

        // Act
        $x = __::merge($a1, $a2);
        $y = __::merge($b1, $b2, $b3);

        // Assert
        $this->assertEquals(['color' => ['favorite' => 'green', 'model' => 3, 'blue'], 10], $x);
        $this->assertEquals(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], $y);
    }

    public function testMergeObject()
    {
        // Arrange
        $a1 = (object)['color' => (object)['favorite' => 'red', 'model' => 3, 5]];
        $a2 = (object)[10, 'color' => (object)['favorite' => 'green', 'blue']];
        $b1 = (object)['a' => 0];
        $b2 = (object)['a' => 1, 'b' => 2, 5];
        $b3 = (object)['c' => 3, 'd' => 4, 6];

        // Act
        $x = __::merge($a1, $a2);
        $y = __::merge($b1, $b2, $b3);

        // Assert
        $this->assertEquals((object)['color' => (object)['favorite' => 'green', 'model' => 3, 'blue'], 10], $x);
        $this->assertEquals((object)['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 6], $y);
    }

    public function testMergeIterable()
    {
        // Arrange
        $a1 = new ArrayIterator(['color' => ['favorite' => 'red', 'model' => 3, 5], 3]);
        $a2 = new ArrayIterator([10, 'color' => ['favorite' => 'green', 'blue']]);

        // Act
        $x = __::merge($a1, $a2);

        // Assert
        // Check we got back an array.
        $this->assertTrue(is_array($x));
        $xValues = [];
        foreach ($x as $key => $value) {
            $xValues[$key] = $value;
        }
        $this->assertEquals(new ArrayIterator(['color' => ['favorite' => 'red', 'model' => 3, 5], 3]), $a1);
        $this->assertEquals(new ArrayIterator([10, 'color' => ['favorite' => 'green', 'blue']]), $a2);
        $this->assertEquals(['color' => ['favorite' => 'green', 'model' => 3, 'blue'], 10], $xValues);
    }
}
