<?php

namespace __\Test\Strings;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class WordsTest extends TestCase
{
    public function testWords()
    {
        // Arrange
        $a = 'fred, barney, & pebbles';
        $b = 'fred, barney, & pebbles';
        $bPattern = '/[^, ]+/';
        $c = '';
        $d = 'fooBar';

        // Act
        $x = __::words($a);
        $y = __::words($b, $bPattern);
        $z = __::words($c);
        $u = __::words($d);

        // Assert
        $this->assertEquals(['fred', 'barney', 'pebbles'], $x);
        $this->assertEquals(['fred', 'barney', '&', 'pebbles'], $y);
        $this->assertEquals([], $z);
        $this->assertEquals(['foo', 'Bar'], $u);
    }
}
