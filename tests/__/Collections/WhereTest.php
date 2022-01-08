<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class WhereTest extends TestCase
{
    public function testWhere()
    {
        // Arrange
        $a = [
            ['name' => 'fred', 'age' => 32],
            ['name' => 'maciej', 'age' => 16],
            ['a' => 'b', 'c' => 'd']
        ];

        // Act
        $x = __::where($a, ['age' => 16]);
        $x2 = __::where($a, ['age' => 16, 'name' => 'fred']);
        $x3 = __::where($a, ['name' => 'maciej', 'age' => 16]);
        $x4 = __::where($a, ['name' => 'unknown']);

        // Assert
        $this->assertEquals([$a[1]], $x);
        $this->assertEquals([], $x2);
        $this->assertEquals([$a[1]], $x3);
        $this->assertEquals([], $x4);
    }

    public function testWhereIterable()
    {
        // Arrange
        $a = new ArrayIterator([
            ['name' => 'fred', 'age' => 32],
            ['name' => 'maciej', 'age' => 16],
            ['a' => 'b', 'c' => 'd']
        ]);

        // Act
        $x = __::where($a, ['age' => 16]);
        $x2 = __::where($a, ['age' => 16, 'name' => 'fred']);
        $x3 = __::where($a, ['name' => 'maciej', 'age' => 16]);
        $x4 = __::where($a, ['name' => 'unknown']);

        // Assert
        $this->assertEquals([$a[1]], $x);
        $this->assertEquals([], $x2);
        $this->assertEquals([$a[1]], $x3);
        $this->assertEquals([], $x4);
    }
}
