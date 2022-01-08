<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class SplitTest extends TestCase
{    public function testSplit()
{
    // Arrange
    $a = 'github.com';
    $b = 'a-b-c';

    // Act
    $x = __::split($a, '.');
    $y = __::split($b, '-');
    $z = __::split($b, '-', 2);

    // Assert
    $this->assertEquals(['github', 'com'], $x);
    $this->assertEquals(['a', 'b', 'c'], $y);
    $this->assertEquals(['a', 'b-c'], $z);
}

}
