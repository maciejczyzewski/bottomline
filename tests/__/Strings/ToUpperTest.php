<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class ToUpperTest extends TestCase
{
    public function testToUpper()
    {
        // Arrange
        $a = '--foo-bar--';
        $b = 'fooBar';
        $c = '__foo_bar__';

        // Act
        $x = __::toUpper($a);
        $y = __::toUpper($b);
        $z = __::toUpper($c);

        // Assert
        $this->assertEquals('--FOO-BAR--', $x);
        $this->assertEquals('FOOBAR', $y);
        $this->assertEquals('__FOO_BAR__', $z);
    }
}
