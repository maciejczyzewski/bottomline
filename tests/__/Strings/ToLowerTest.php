<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class ToLowerTest extends TestCase
{    public function testToLower()
{
    // Arrange
    $a = '--Foo-Bar--';
    $b = 'fooBar';
    $c = '__FOO_BAR__';

    // Act
    $x = __::toLower($a);
    $y = __::toLower($b);
    $z = __::toLower($c);

    // Assert
    $this->assertEquals('--foo-bar--', $x);
    $this->assertEquals('foobar', $y);
    $this->assertEquals('__foo_bar__', $z);
}

}
