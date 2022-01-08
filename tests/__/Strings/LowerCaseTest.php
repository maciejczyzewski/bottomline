<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class LowerCaseTest extends TestCase
{
    public function testLowerCase()
    {
        // Arrange
        $a = '--Foo-Bar--';
        $b = 'fooBar';
        $c = '__FOO_BAR__';

        // Act
        $x = __::lowerCase($a);
        $y = __::lowerCase($b);
        $z = __::lowerCase($c);

        // Assert
        $this->assertEquals('foo bar', $x);
        $this->assertEquals('foo bar', $y);
        $this->assertEquals('foo bar', $z);
    }
}
