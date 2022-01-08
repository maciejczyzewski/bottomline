<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class StartCaseTest extends TestCase
{
    public function testStartCase()
    {
        // Arrange
        $a = '--foo-bar--';
        $b = 'fooBar';
        $c = '__FOO_BAR__';

        // Act
        $x = __::startCase($a);
        $y = __::startCase($b);
        $z = __::startCase($c);

        // Assert
        $this->assertEquals('Foo Bar', $x);
        $this->assertEquals('Foo Bar', $y);
        $this->assertEquals('FOO BAR', $z);
    }
}
