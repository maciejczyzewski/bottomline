<?php

namespace __\Test\Arrays;

use __;
use PHPUnit\Framework\TestCase;

class DropRightWhileTest extends TestCase
{
    public function testDropRightWhileWithPrimitive()
    {
        $out1 = __::dropRightWhile([1, 2, 3, 3], 3);
        $out2 = __::dropRightWhile([1, 2], 3);
        $out3 = __::dropRightWhile([], 3);

        $this->assertEquals([1, 2], $out1);
        $this->assertEquals([1, 2], $out2);
        $this->assertEquals([], $out3);
    }

    public function testDropRightWhileWithCallback()
    {
        $f = static function ($item) {
            return $item >= 3;
        };

        $out1 = __::dropRightWhile([1, 2, 3, 4], $f);
        $out2 = __::dropRightWhile([1, 2], $f);
        $out3 = __::dropRightWhile([], $f);

        $this->assertEquals([1, 2], $out1);
        $this->assertEquals([1, 2], $out2);
        $this->assertEquals([], $out3);
    }
}
