<?php

namespace __\Test\Arrays;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class DropTest extends TestCase
{
    public function testDrop()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::drop($a);
        $y = __::drop($a, 2);
        $z = __::drop($a, 5);
        $xa = __::drop($a, 0);

        // Assert
        $this->assertEquals([2, 3], $x);
        $this->assertEquals([3], $y);
        $this->assertEquals([], $z);
        $this->assertEquals([1, 2, 3], $xa);
    }

    public function testDropWithIterator()
    {
        $a = [1, 2, 3, 4, 5];
        $aItr = new ArrayIterator($a);

        $expected = __::drop($a, 3);
        $actual = __::drop($aItr, 3);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }

    public function testDropWithIteratorAggregate()
    {
        $a = [1, 2, 3, 4, 5];
        $aItrAgg = new MockIteratorAggregate($a);

        $expected = __::drop($a, 3);
        $actual = __::drop($aItrAgg, 3);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }

    public function testDropWithGenerator()
    {
        $a = [1, 2, 3, 4, 5];
        $generator = call_user_func(function () use ($a) {
            foreach ($a as $item) {
                yield $item;
            }
        });

        $this->assertInstanceOf(\Generator::class, $generator);

        $expected = __::drop($a, 3);
        $actual = __::drop($generator, 3);
        $itrSize = 0;

        foreach ($actual as $i => $item) {
            ++$itrSize;
            $this->assertEquals($item, $expected[$i]);
        }

        $this->assertEquals(count($expected), $itrSize);
    }
}
