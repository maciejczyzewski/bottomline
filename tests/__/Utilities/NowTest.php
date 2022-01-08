<?php

namespace __\Test\Utilities;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class NowTest extends TestCase
{
    public function testNow()
    {
        // Act
        $x = __::now();

        // Assert
        $this->assertEquals(true, is_numeric($x));
    }
}
