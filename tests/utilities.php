<?php

class UtilitiesTest extends \PHPUnit\Framework\TestCase {

    public function testNow() {

        // Act
        $x = __::now();

        // Assert
        $this->assertEquals(true, is_numeric($x));
    }

}
