<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class ReduceRightTest extends TestCase
{
    public function testReduceRightArray()
    {
        // Arrange
        $a = ['a', 'b', 'c'];
        $aReducer = function ($word, $char) {
            return $word . $char;
        };

        // Act
        $x = __::reduceRight($a, $aReducer, '');

        // Assert
        $this->assertEquals('cba', $x);
    }

    public function testReduceRightIterable()
    {
        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            // Arrange
            $a = new ArrayIterator(['a', 'b', 'c']);
            $aReducer = function ($word, $char) {
                return $word . $char;
            };

            // Act
            $x = __::reduceRight($a, $aReducer, '');

            // Assert
            $this->assertEquals('cba', $x);
        }
    }
}
