<?php

class UtilitiesTest extends PHPUnit_Framework_TestCase {

    public function testIsEmail() {
        // Arrange
        $a  = 'test@test.com';
        $a2 = 'test_test.com';

        // Act
        $x  = __::isEmail($a);
        $x2 = __::isEmail($a2);

        // Assert
        $this->assertEquals(true, $x);
        $this->assertEquals(false, $x2);
    }

    public function testNow() {
        // Act
        $x = __::now();

        // Assert
        $this->assertEquals(true, is_numeric($x));
    }


    public function testStringContains() {
        // Arrange
        $a  = 'testi';
        $b  = 'testing wafflecones';
        $a2 = 'waffle';

        // Act
        $x  = __::stringContains($a, $b);
        $x2 = __::stringContains($a, $b, 5);
        $x3 = __::stringContains($a2, $b);
        $x4 = __::stringContains($a2, $b, 7);

        // Assert
        $this->assertEquals(true, $x);
        $this->assertEquals(false, $x2);
        $this->assertEquals(true, $x3);
        $this->assertEquals(true, $x4);

    }

}
