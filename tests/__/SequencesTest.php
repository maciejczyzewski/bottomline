<?php

namespace __\Test;

use __;
use PHPUnit\Framework\TestCase;

class SequencesTest extends TestCase
{
    public function testChainReturnsArray()
    {
        // Arrange
        $collection = [0, 1, 2, 3, null];

        // Act
        $result = __::chain($collection)
            ->compact()
            ->prepend(4)
            ->value();

        // Assert
        $this->assertEquals([4, 1, 2, 3], $result);
    }

    public function testChainReturnsNumber()
    {
        // Arrange
        $collection = [0, 1, 2, 3, null];

        // Act
        $result = __::chain($collection)
            ->compact()
            ->prepend(4)
            ->reduce(function ($sum, $number) {
                return $sum + $number;
            }, 0)
            ->value();

        // Assert
        $this->assertEquals(10, $result);
    }

    public function testChainWithError()
    {
        if (method_exists($this, 'expectException')) {
            // new phpunit
            $this->expectException('\Exception');
        } else {
            // old phpunit
            $this->setExpectedException('\Exception');
        }

        // Arrange
        $collection = [0, 1, 2, 3, null];

        // Act
        __::chain($collection)
            ->randomFunc()
            ->value();
    }
}
