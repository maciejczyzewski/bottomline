<?php

namespace __\Test\Functions;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class SlugTest extends TestCase
{
    public function testSlug()
    {
        // Arrange
        $a = 'Jakieś zdanie z dużą ilością obcych znaków!';

        // Act
        $x = __::slug($a);

        // Assert
        $this->assertEquals('jakies-zdanie-z-duza-iloscia-obcych-znakow', $x);
    }
}
