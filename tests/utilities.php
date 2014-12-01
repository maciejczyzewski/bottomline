<?php

class UtilitiesTest extends PHPUnit_Framework_TestCase {

    public function testNow() {

        // Act
        $x = __::now();

        // Assert
        $this->assertEquals(true, is_numeric($x));
    }

}
