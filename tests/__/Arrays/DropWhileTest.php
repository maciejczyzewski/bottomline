<?php

namespace __\Test\Arrays;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class DropWhileTest extends TestCase
{
    public function testDropWhileWithCallable()
    {
        $arr = [1, 2, 3, 4, 5];

        $out1 = __::dropWhile($arr, static function ($item) {
            return $item < 3;
        });
        $out2 = __::dropWhile($arr, static function ($item) {
            return $item < 0;
        });
        $out3 = __::dropWhile($arr, static function ($item) {
            return $item < 10;
        });

        $this->assertEquals([3, 4, 5], $out1);
        $this->assertEquals([1, 2, 3, 4, 5], $out2);
        $this->assertEquals([], $out3);
    }

    public function testDropWhileWithPrimitive()
    {
        $arr = [1, 1, 2, 3, 4, 5];

        $actual = __::dropWhile($arr, 1);

        $this->assertEquals([2, 3, 4, 5], $actual);
    }

    public function testDropWhileWithIterator()
    {
        $arr = [1, 2, 3, 4, 5];
        $arrItr = new ArrayIterator($arr);

        $f = static function ($item) {
            return $item < 3;
        };
        $expected = __::dropWhile($arr, $f);
        $actual = __::dropWhile($arrItr, $f);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }

    public function testDropWhileWithIteratorAggregate()
    {
        $arr = [1, 2, 3, 4, 5];
        $arrItr = new MockIteratorAggregate($arr);

        $f = static function ($item) {
            return $item < 3;
        };
        $expected = __::dropWhile($arr, $f);
        $actual = __::dropWhile($arrItr, $f);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }

    public function testDropWhileWithGenerator()
    {
        $arr = [1, 2, 3, 4, 5];
        $generator = call_user_func(function () use ($arr) {
            foreach ($arr as $item) {
                yield $item;
            }
        });

        $this->assertInstanceOf(\Generator::class, $generator);

        $f = static function ($item) {
            return $item < 3;
        };
        $expected = __::dropWhile($arr, $f);
        $actual = __::dropWhile($generator, $f);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }

    public function testDropWhileWithMatchAfterDroppingEnds()
    {
        $arr = [1, 1, 2, 1, 1];
        $arrItr = new ArrayIterator($arr);

        $expected = __::dropWhile($arr, 1);
        $actual = __::dropWhile($arrItr, 1);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }
}
