<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class ReduceTest extends TestCase
{
    public function testReduceArray()
    {
        // Arrange
        $a = [1, 2, 3];
        $b = [
            10659489,
            1578484,
            1620331,
            935440,
            944022,
            1037939,
        ];
        $c = [
            ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
            ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
            ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
            ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
            ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
        ];
        $aReducer = function ($accumulator, $value) {
            return $accumulator + $value;
        };
        $bReducer = function ($accumulator, $value, $index) {
            if ($index === 0) {
                $this->assertEquals(10659489, $accumulator);
            }
            return $accumulator + $value;
        };
        $cIndex = 0;
        $cReducer = function ($accumulator, $value, $index, $collection) use (&$c, &$cIndex) {
            $this->assertEquals($c, $collection);
            $this->assertEquals($cIndex++, $index);
            if (isset($accumulator[$value['city']])) {
                $accumulator[$value['city']]++;
            } else {
                $accumulator[$value['city']] = 1;
            }
            return $accumulator;
        };

        // Act
        $x = __::reduce($a, $aReducer, 2);
        $y = __::reduce($b, $bReducer);
        $z = __::reduce($c, $cReducer, []);

        // Assert
        $this->assertEquals(8, $x);
        $this->assertEquals(27435194, $y);
        $this->assertEquals([
            'Indianapolis' => 2,
            'Plainfield' => 1,
            'San Diego' => 1,
            'Mountain View' => 1,
        ], $z);
    }

    public function testReduceObject()
    {
        // Arrange
        $a = new \stdClass();
        $a->paris = 10659489;
        $a->marseille = 1578484;
        $a->lyon = 1620331;
        $a->toulouse = 935440;
        $a->nice = 944022;
        $a->lille = 1037939;
        $aReducer = function ($accumulator, $value) {
            return $accumulator + $value;
        };
        $b = (object)[
            'a' => 1,
            'b' => 2,
            'c' => 1
        ];
        $bReducer = function ($accumulator, $value, $key) {
            if (!isset($accumulator[$value])) {
                $accumulator[$value] = [];
            }
            $accumulator[$value][] = $key;
            return $accumulator;
        };

        // Act
        $x = __::reduce($a, $aReducer, 0);
        $y = __::reduce($b, $bReducer, []);

        // Assert
        $this->assertEquals(16775705, $x);
        $this->assertEquals([
            '1' => ['a', 'c'],
            '2' => ['b']
        ], $y);
    }

    public function testReduceIterable()
    {

        // Arrange
        $a = new ArrayIterator([1, 2, 3]);
        $aReducer = function ($accumulator, $value) {
            return $accumulator + $value;
        };

        // Act
        $x = __::reduce($a, $aReducer, 2);

        // Assert
        $this->assertEquals(8, $x);
    }
}
