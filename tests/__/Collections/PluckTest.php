<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class PluckTest extends TestCase
{
    public function testPluck()
    {
        // Arrange
        $a = [
            ['foo' => 'bar', 'bis' => 'ter', '' => 0],
            ['foo' => 'bar2', 'bis' => 'ter2', '' => 1],
        ];

        $b = new \stdClass();
        $b->one = new \stdClass();
        $b->one->foo = 'bar';
        $b->two = new \stdClass();
        $b->two->foo = 'bar2';
        $b->three = new \stdClass();
        $c = [$b->one, $b->two];

        $d = [
            ['foo' => ['bar' => ['baz' => 1]]],
            ['foo' => ['bar' => ['baz' => 2]]]
        ];
        $e = new \stdClass();
        $e->one = new \stdClass();
        $e->one->foo = new \stdClass();
        $e->one->foo->bar = ['baz' => 1];
        $e->two = new \stdClass();
        $e->two->foo = new \stdClass();
        $e->two->foo->bar = new \stdClass();
        $e->two->foo->bar->baz = 2;

        // Act
        $x = __::pluck($a, 'foo');
        $x2 = __::pluck($a, '');

        $y = __::pluck($b, 'foo');
        $y2 = __::pluck($c, 'foo');

        $z = __::pluck($d, 'foo.bar.baz');
        $z2 = __::pluck($e, 'foo.bar.baz');

        // Assert
        $this->assertEquals(['bar', 'bar2'], $x);
        $this->assertEquals([0, 1], $x2);

        $this->assertEquals(['bar', 'bar2', null], $y);
        $this->assertEquals(['bar', 'bar2'], $y2);

        $this->assertEquals([1, 2], $z);
        $this->assertEquals([1, 2], $z2);
    }

    public function testPluckIterable()
    {
        // Arrange
        $a = new ArrayIterator([
            ['foo' => 'bar', 'bis' => 'ter', '' => 0],
            ['foo' => 'bar2', 'bis' => 'ter2', '' => 1],
        ]);

        // Act
        $x = __::pluck($a, 'foo');
        $x2 = __::pluck($a, '');

        // Assert
        $this->assertEquals(['bar', 'bar2'], $x);
        $this->assertEquals([0, 1], $x2);
    }
}
