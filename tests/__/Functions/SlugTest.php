<?php

namespace __\Test\Functions;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class SlugTest extends TestCase
{
    public function testSlugWithUtf8()
    {
        $input = 'Jakieś zdanie z dużą ilością obcych znaków!';
        $actual = __::slug($input);

        $this->assertEquals('jakies-zdanie-z-duza-iloscia-obcych-znakow', $actual);
    }

    public function testSlugWithAscii()
    {
        $input = 'Hello World!';
        $actual = __::slug($input);

        $this->assertEquals('hello-world', $actual);
    }
}
