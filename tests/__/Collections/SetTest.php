<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\ArrayAccessible;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    public function testSet()
    {
        // Arrange
        $a = ['foo' => ['bar' => 'ter']];

        // Act
        $x = __::set($a, 'foo.baz.ber', 'fer');
        $y = __::set($a, 'foo.bar', 'fer2');

        // Assert
        $this->assertEquals(['foo' => ['bar' => 'ter']], $a);
        $this->assertEquals(['ber' => 'fer'], $x['foo']['baz']);
        $this->assertEquals(['foo' => ['bar' => 'fer2']], $y);
    }

    public function testSetArrayAccess()
    {
        $aa = new ArrayAccessible();

        __::set($aa, 'foo.ubi', [
            'bar' => 'qaz',
        ]);
        __::set($aa, 'faa.raot.uft', 100);

        $this->assertTrue(is_array(__::get($aa, 'foo')));
        $this->assertTrue(is_array(__::get($aa, 'faa')));
        $this->assertTrue(is_array(__::get($aa, 'faa.raot')));

        $this->assertEquals('qaz', __::get($aa, 'foo.ubi.bar'));
        $this->assertEquals(42, __::get($aa, 'foo.nonexistent', 42));
    }

    public function testSetObject()
    {
        // Arrange.
        $a = (object)['foo' => (object)['bar' => 'ter']];

        // Act.
        $x = __::set($a, 'foo.baz.ber', 'fer');
        $y = __::set($a, 'foo.bar', 'fer2');

        // Assert.
        $this->assertEquals((object )['foo' => (object)['bar' => 'ter']], $a);
        $this->assertEquals((object)['ber' => 'fer'], $x->foo->baz);
        $this->assertEquals((object)['foo' => (object)['bar' => 'fer2']], $y);
    }

    public function testSetOverride()
    {
        // Arrange
        $a = ['foo' => ['bar' => 'ter']];

        // Act
        $x = __::set($a, 'foo.bar.not_exist', 'baz');

        // Assert.
        $this->assertEquals(['foo' => ['bar' => 'ter']], $a);
        $this->assertEquals(['foo' => ['bar' => ['not_exist' => 'baz']]], $x);
    }

    public function testSetIterable()
    {
        // Arrange
        $a = new ArrayIterator(['foo' => ['bar' => 'ter']]);

        // Act
        $x = __::set($a, 'foo.baz.ber', 'fer');

        // Assert
        $this->assertEquals(new ArrayIterator(['foo' => ['bar' => 'ter']]), $a);
        $this->assertEquals(['ber' => 'fer'], $x['foo']['baz']);
    }
}
