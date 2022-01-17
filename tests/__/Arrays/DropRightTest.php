<?php

namespace __\Test\Arrays;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class DropRightTest extends TestCase
{
    public function testDropRight()
    {
        $a = [1, 2, 3];

        $x = __::dropRight($a);
        $y = __::dropRight($a, 2);
        $z = __::dropRight($a, 5);
        $xa = __::dropRight($a, 0);

        $this->assertEquals([1, 2], $x);
        $this->assertEquals([1], $y);
        $this->assertEquals([], $z);
        $this->assertEquals([1, 2, 3], $xa);
    }
}
