<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class UpperCaseTest extends TestCase
{    public function testUpperCase()
{
    // Arrange
    $a = '--foo-bar';
    $b = 'fooBar';
    $c = '__foo_bar__';

    // Act
    $x = __::upperCase($a);
    $y = __::upperCase($b);
    $z = __::upperCase($c);

    // Assert
    $this->assertEquals('FOO BAR', $x);
    $this->assertEquals('FOO BAR', $y);
    $this->assertEquals('FOO BAR', $z);
}

}
