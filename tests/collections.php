<?php

class CollectionsTest extends PHPUnit_Framework_TestCase
{
    // ...

    public function testFilter()
    {
        // Arrange
        $a = [1, 2, 3, 4, 5];
        $b = [
            ['name' => 'fred',   'age' => 32],
            ['name' => 'maciej', 'age' => 16]
        ];

        // Act
        $x = __::filter($a, function($n) {
            return $n > 3;
        });
        $y = __::filter($b, function($n) {
            return $n['age'] == 16;
        });

        // Assert
        $this->assertEquals([4, 5], $x);
        $this->assertEquals([$b[1]], $y);
    }

    public function testFirst()
    {
        // Arrange
        $a = [1, 2, 3, 4, 5];

        // Act
        $x = __::first($a, 2);

        // Assert
        $this->assertEquals([1, 2], $x);
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

    public function testLast()
    {
        // Arrange
        $a = [1, 2, 3, 4, 5];

        // Act
        $x = __::last($a, 2);

        // Assert
        $this->assertEquals([4, 5], $x);
    }

    public function testMap()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::map($a, function($n) {
            return $n * 3;
        });

        // Assert
        $this->assertEquals([3, 6, 9], $x);
    }

    public function testMax()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::max($a);

        // Assert
        $this->assertEquals(3, $x);
    }


    public function testMin()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::min($a);

        // Assert
        $this->assertEquals(1, $x);
    }

    public function testPluck()
    {
        // Arrange
        $a = [
            ['foo' => 'bar',  'bis' => 'ter' ],
            ['foo' => 'bar2', 'bis' => 'ter2'],
        ];

        // Act
        $x = __::pluck($a, 'foo');

        // Assert
        $this->assertEquals(['bar', 'bar2'], $x);
    }

    public function testWhere()
    {
        // Arrange
        $a = [
            ['name' => 'fred',   'age' => 32],
            ['name' => 'maciej', 'age' => 16]
        ];

        // Act
        $x = __::where($a, ['age' => 16]);

        // Assert
        $this->assertEquals([$a[1]], $x);
    }

    // ...
}