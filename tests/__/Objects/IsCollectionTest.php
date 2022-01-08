<?php

namespace __\Test\Objects;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class IsCollectionTest extends TestCase
{
    public function testIsCollection()
    {
        // Arrange.
        $a = [1, 2, 3];
        $b = (object) [1, 2, 3];
        $c = 'string';

        // Act.
        $x = __::isCollection($a);
        $y = __::isCollection($b);
        $z = __::isCollection($c);

        // Assert.
        $this->assertEquals(true, $x);
        $this->assertEquals(true, $y);
        $this->assertEquals(false, $z);
    }
}
