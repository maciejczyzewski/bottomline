<?php

class ObjectsTest extends \PHPUnit\Framework\TestCase
{
    // ...

    public function testIsArray()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::isArray($a);

        // Assert
        $this->assertEquals(true, $x);
    }

    public function testIsEmail()
    {
        // Arrange
        $a = 'test@test.com';

        // Act
        $x = __::isEmail($a);

        // Assert
        $this->assertEquals(true, $x);
    }

    public function testIsFunction()
    {
        // Arrange
        $a = function ($a) {
            return $a + 2;
        };

        // Act
        $x = __::isFunction($a);

        // Assert
        $this->assertEquals(true, $x);
    }

    public function testIsNull()
    {
        // Arrange
        $a = null;

        // Act
        $x = __::isNull($a);

        // Assert
        $this->assertEquals(true, $x);
    }

    public function testIsNumber()
    {
        // Arrange
        $a = 123;

        // Act
        $x = __::isNumber($a);

        // Assert
        $this->assertEquals(true, $x);
    }

    public function testIsObject()
    {
        // Arrange
        $a = 'fred';

        // Act
        $x = __::isObject($a);

        // Assert
        $this->assertEquals(false, $x);
    }

    public function testIsString()
    {
        // Arrange
        $a = 'fred';

        // Act
        $x = __::isString($a);

        // Assert
        $this->assertEquals(true, $x);
    }

    public function testIsCollection()
    {
        // Arrange.
        $a = [1, 2, 3];
        $b = (object) [1, 2, 3];
        $c = 'string';

        // Act.
        $x = __::isCollection($a);
        $y = __::isCollection($b);
        $z = __::isCollection($c);

        // Assert.
        $this->assertEquals(true, $x);
        $this->assertEquals(true, $y);
        $this->assertEquals(false, $z);
    }

    /**
     * Should compare primitives.
     */
    public function testIsEqualPrimitives()
    {
        // Arrange.
        $pairs = [
            [1, '1', false],
            ['1', '1', true]
        ];

        // Act.
        $results = [];
        foreach ($pairs as $pair) {
            $results[] = __::isEqual($pair[0], $pair[1]);
        }

        // Assert.
        foreach ($pairs as $i => $pair) {
            // print_r($pair);
            $this->assertEquals($pair[2], $results[$i]);
        }
    }

    /**
     * Should compare arrays, with index order.
     */
    public function testIsEqualArrays()
    {
        // Arrange.
        $a1 = [1, 2, 3];
        $a2 = [2, 1, 3];
        $b1 = [1, 2, 3];
        $b2 = [1, 2, 3];

        // Act.
        $x = __::isEqual($a1, $a2);
        $y = __::isEqual($b1, $b2);

        // Assert.
        $this->assertEquals(false, $x);
        $this->assertEquals(true, $y);
    }

    /**
     * Should compare arrays recursively.
     */
    public function testIsEqualArraysRecursive()
    {
        // Arrange.
        $a1 = ['paris'=> [42, 66], 'london'=> [33, 23]];
        $a2 = ['london'=> [33, 23], 'paris'=> [42, 66]];
        $b1 = ['paris'=> [42, 66], 'london'=> [33, 23]];
        $b2 = ['paris'=> [42, 67], 'london'=> [33, 23]];

        // Act.
        $x = __::isEqual($a1, $a2);
        $y = __::isEqual($b1, $b2);

        // Assert.
        $this->assertEquals(true, $x);
        $this->assertEquals(false, $y);
    }

    // TODO Objects.

    // ...
}
