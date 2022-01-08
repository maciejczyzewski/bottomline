<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class KebabCaseTest extends TestCase
{
    public function testKebabCase()
    {
        // Arrange
        $a = 'Foo Bar';
        $b = 'fooBar';
        $c = '__FOO_BAR__';

        // Act
        $x = __::kebabCase($a);
        $y = __::kebabCase($b);
        $z = __::kebabCase($c);

        // Assert
        $this->assertEquals('foo-bar', $x);
        $this->assertEquals('foo-bar', $y);
        $this->assertEquals('foo-bar', $z);
    }
}
