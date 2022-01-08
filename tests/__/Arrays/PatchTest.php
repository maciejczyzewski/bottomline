<?php

namespace __\Test\Arrays;

use __;
use PHPUnit\Framework\TestCase;

class PatchTest extends TestCase
{
    public function testPatch()
    {
        // Arrange
        $a = [1, 1, 1, 'contacts' => ['country' => 'US', 'tel' => [123]], 99];
        $p = ['/0' => 2, '/1' => 3, '/contacts/country' => 'CA', '/contacts/tel/0' => 3456];

        // Act
        $x = __::patch($a, $p);

        // Assert
        $this->assertEquals([2, 3, 1, 'contacts' => ['country' => 'CA', 'tel' => [3456]], 99], $x);
    }
}
