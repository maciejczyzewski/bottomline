<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class CamelCaseTest extends TestCase
{
    public function testCamelCase()
    {
        // Arrange
        $a = 'Foo Bar';
        $b = '--foo-bar--';
        $c = '__FOO_BAR__';

        // Act
        $x = __::camelCase($a);
        $y = __::camelCase($b);
        $z = __::camelCase($c);

        // Assert
        $this->assertEquals('fooBar', $x);
        $this->assertEquals('fooBar', $y);
        $this->assertEquals('fooBar', $z);
    }
}
