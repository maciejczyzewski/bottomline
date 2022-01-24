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
        $arr = [1, 2, 3];

        $out1 = __::dropRight($arr);
        $out2 = __::dropRight($arr, 2);
        $out3 = __::dropRight($arr, 5);
        $out4 = __::dropRight($arr, 0);

        $this->assertEquals([1, 2], $out1);
        $this->assertEquals([1], $out2);
        $this->assertEquals([], $out3);
        $this->assertEquals([1, 2, 3], $out4);
    }

    public function testDropRightWithIterator()
    {
        $a = [1, 2, 3, 4, 5];
        $aItr = new ArrayIterator($a);

        $expected = __::dropRight($a, 3);
        $actual = __::dropRight($aItr, 3);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }

    public function testDropRightWithIteratorAggregate()
    {
        $a = [1, 2, 3, 4, 5];
        $aItrAgg = new MockIteratorAggregate($a);

        $expected = __::dropRight($a, 3);
        $actual = __::dropRight($aItrAgg, 3);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }

    public function testDropRightWithGenerator()
    {
        $a = [1, 2, 3, 4, 5];
        $generator = call_user_func(function () use ($a) {
            foreach ($a as $item) {
                yield $item;
            }
        });

        $this->assertInstanceOf(\Generator::class, $generator);

        $expected = __::dropRight($a, 3);
        $actual = __::dropRight($generator, 3);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }
}
