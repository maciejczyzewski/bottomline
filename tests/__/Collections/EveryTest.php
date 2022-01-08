<?php

namespace __\Test\Collections;

use __;
use PHPUnit\Framework\TestCase;

class EveryTest extends TestCase
{
    public function testEvery()
    {
        // Arrange.
        $a = [true, 1, null, 'yes'];
        $b = [true, false];
        $c = [1, 3, 4];

        // Act.
        $x = __::every($a, function ($v) {
            return is_bool($v);
        });
        $y = __::every($b, function ($v) {
            return is_bool($v);
        });
        $z = __::every($c, function ($v) {
            return is_int($v);
        });

        // Assert
        $this->assertFalse($x);
        $this->assertTrue($y);
        $this->assertTrue($z);
    }
}
