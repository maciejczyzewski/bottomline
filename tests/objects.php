<?php

class ObjectsTest extends PHPUnit_Framework_TestCase
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
        $a = function ($a) { return $a + 2; };

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

    // ...
}