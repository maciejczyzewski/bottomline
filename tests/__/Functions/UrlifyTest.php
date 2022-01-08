<?php

namespace __\Test\Functions;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class UrlifyTest extends TestCase
{
    public function testUrlify()
    {
        // Arrange
        $a = 'I love https://google.com';
        $b = 'I love http://google.com';
        $c = 'I love google.com !';

        // Act
        $x = __::urlify($a);
        $y = __::urlify($b);
        $z = __::urlify($c);

        // Assert
        $this->assertEquals('I love <a href="https://google.com">google.com</a>', $x);
        $this->assertEquals('I love <a href="http://google.com">google.com</a>', $y);
        $this->assertEquals('I love <a href="http://google.com">google.com</a> !', $z);
    }
}
