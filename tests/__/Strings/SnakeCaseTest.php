<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class SnakeCaseTest extends TestCase
{
    public function testSnakeCase()
    {
        // Arrange
        $a = 'Foo Bar';
        $b = 'fooBar';
        $c = '--FOO-BAR--';

        // Act
        $x = __::snakeCase($a);
        $y = __::snakeCase($b);
        $z = __::snakeCase($c);

        // Assert
        $this->assertEquals('foo_bar', $x);
        $this->assertEquals('foo_bar', $y);
        $this->assertEquals('foo_bar', $z);
    }
}
