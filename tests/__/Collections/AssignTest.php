<?php

namespace __\Test\Collections;

use __;
use PHPUnit\Framework\TestCase;

class AssignTest extends TestCase
{
    public function testAssign()
    {
        // Arrange
        $a1 = ['color' => ['favorite' => 'red', 'model' => 3, 5], 3];
        $a2 = [10, 'color' => ['favorite' => 'green', 'blue']];
        $b1 = ['a' => 0];
        $b2 = ['a' => 1, 'b' => 2];
        $b3 = ['c' => 3, 'd' => 4];

        // Act
        $x = __::assign($a1, $a2);
        $y = __::assign($b1, $b2, $b3);

        // Assert
        $this->assertEquals(['color' => ['favorite' => 'green', 'blue'], 10], $x);
        $this->assertEquals(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], $y);
    }

    public function testAssignObject()
    {
        // Arrange
        $a1 = (object)['color' => (object)['favorite' => 'red', 5]];
        $a2 = (object)[10, 'color' => (object)['favorite' => 'green', 'blue']];
        $b1 = (object)['a' => 0];
        $b2 = (object)['a' => 1, 'b' => 2, 5];
        $b3 = (object)['c' => 3, 'd' => 4, 6];

        // Act
        $x = __::assign($a1, $a2);
        $y = __::assign($b1, $b2, $b3);

        // Assert
        $this->assertEquals((object)['color' => (object)['favorite' => 'green', 'blue'], 10], $x);
        $this->assertEquals((object)['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 6], $y);
    }
}
