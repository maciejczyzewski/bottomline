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

}
