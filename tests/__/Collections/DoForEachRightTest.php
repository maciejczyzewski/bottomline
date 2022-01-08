<?php

namespace __\Test\Collections;

use __;
use PHPUnit\Framework\TestCase;

class DoForEachRightTest extends TestCase
{
    public function testDoForEachRight()
    {
        // Arrange
        $makeAppend = function (&$array) {
            return function ($value) use (&$array) {
                $array[] = $value;
            };
        };
        $makeMapper = function (&$array) {
            return function ($value, $key) use (&$array) {
                $array[$key] = $value;
            };
        };
        $a = [1, 2, 3];
        $b = ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'];

        // Act.
        $aAppend = [];
        $aMapped = [];
        $bMapped = [];
        __::doForEachRight($a, $makeAppend($aAppend));
        __::doForEachRight($a, $makeMapper($aMapped));
        __::doForEachRight($b, $makeMapper($bMapped));

        // Assert
        $this->assertEquals(array_reverse($a), $aAppend);
        $this->assertEquals($a, $aMapped);
        $this->assertEquals($b, $bMapped);
    }
}
