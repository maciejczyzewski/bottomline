<?php

namespace __\Test;

use __;
use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
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

    public function testTruncate()
    {
        // Arrange
        $a = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et mi orci.';

        // Act
        $x = __::truncate($a, 5);

        // Assert
        $this->assertEquals('Lorem ipsum dolor sit amet, ...', $x);
    }

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
