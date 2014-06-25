<?php

class ChainingTest extends PHPUnit_Framework_TestCase
{
    // ...

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

    // ...
}