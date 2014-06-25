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

    // ...
}