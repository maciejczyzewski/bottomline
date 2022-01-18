<?php

namespace __\Test\Arrays;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
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

    public function testDropRightWhileWithIterator()
    {
        $a = [1, 2, 3, 4, 5];
        $aItr = new ArrayIterator($a);

        $expected = __::dropRightWhile($a, 3);
        $actual = __::dropRightWhile($aItr, 3);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }

    public function testDropRightWhileWithIteratorAggregate()
    {
        $a = [1, 2, 3, 4, 5];
        $aItrAgg = new MockIteratorAggregate($a);

        $expected = __::dropRightWhile($a, 3);
        $actual = __::dropRightWhile($aItrAgg, 3);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }

    public function testDropRightWhileWithGenerator()
    {
        $a = [1, 2, 3, 4, 5];
        $generator = call_user_func(function () use ($a) {
            foreach ($a as $item) {
                yield $item;
            }
        });

        $this->assertInstanceOf(\Generator::class, $generator);

        $expected = __::dropRightWhile($a, 3);
        $actual = __::dropRightWhile($generator, 3);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }
}
