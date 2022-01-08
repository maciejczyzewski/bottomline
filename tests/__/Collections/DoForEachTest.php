<?php

namespace __\Test\Collections;

use __;
use PHPUnit\Framework\TestCase;

class DoForEachTest extends TestCase
{
    public function testDoForEach()
    {
        // Arrange
        $makeMapper = function (&$array) {
            return function ($value, $key) use (&$array) {
                $array[$key] = $value;
            };
        };
        $a = [1, 2, 3];
        $b = ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'];
        $c = (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'];

        // Act.
        $aMapped = [];
        $bMapped = [];
        $cMapped = [];
        __::doForEach($a, $makeMapper($aMapped));
        __::doForEach($b, $makeMapper($bMapped));
        __::doForEach($c, $makeMapper($cMapped));

        // Assert
        $this->assertEquals($a, $aMapped);
        $this->assertEquals($b, $bMapped);
        $this->assertEquals($c, (object)$cMapped);
        $this->assertEquals((array)$c, $cMapped);
    }

    public function testDoForEachPrematureReturn()
    {
        // Arrange
        $makeMapper = function (&$array, $returnAtKey) {
            return function ($value, $key) use (&$array, $returnAtKey) {
                $array[$key] = $value;
                if ($returnAtKey === $key) {
                    return false;
                }
            };
        };
        $a = [1, 2, 3, 4];
        $b = ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'];

        // Act.
        $aMapped = [];
        $bMapped = [];
        __::doForEach($a, $makeMapper($aMapped, 1));
        __::doForEach($b, $makeMapper($bMapped, 'city'));

        // Assert
        $this->assertEquals([1, 2], $aMapped);
        $this->assertEquals(['state' => 'IN', 'city' => 'Indianapolis'], $bMapped);
    }
}
