<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\ArrayAccessible;
use PHPUnit\Framework\TestCase;

class GetTest extends TestCase
{
    public function testGetArrays()
    {
        // Arrange
        $o = new \stdClass();
        $a = [
            'foo' => ['bar' => 'ter'],
            'baz' => ['foo' => ['obj' => $o]]
        ];

        // Act
        $x = __::get($a, 'foo.bar');
        $x2 = __::get($a, 'foo.bar', 'default');
        $y = __::get($a, 'foo.baz');
        $y2 = __::get($a, 'foo.baz', 'default');
        $y3 = __::get($a, 'foo.baz', function () {
            return 'default_from_callback';
        });
        $z = __::get($a, 'baz.foo.obj');

        // Assert
        $this->assertEquals('ter', $x);
        $this->assertEquals('ter', $x2);
        $this->assertNull($y);
        $this->assertEquals('default', $y2);
        $this->assertEquals('default_from_callback', $y3);
        $this->assertEquals($o, $z);
    }

    public function testGetArrayAccess()
    {
        $aa = new ArrayAccessible();
        $aa['foo'] = [
            'bar' => 'quim',
        ];
        $aa['bar'] = 5;
        $aa['caz'] = new \stdClass();
        $aa['caz']->daer = 'heft';

        $this->assertEquals('quim', __::get($aa, 'foo.bar'));
        $this->assertEquals(5, __::get($aa, 'bar'));
        $this->assertEquals('heft', __::get($aa, 'caz.daer'));

        $this->assertNull(__::get($aa, 'foo.cat'));
    }

    public function testGetObjects()
    {
        // Arrange
        $o = new \stdClass();
        $a = new \stdClass();
        $a->foo = new \stdClass();
        $a->foo->bar = 'ter';
        $a->baz = new \stdClass();
        $a->baz->foo = new \stdClass();
        $a->baz->foo->obj = $o;

        // Act
        $x = __::get($a, 'foo.bar');
        $x2 = __::get($a, 'foo.bar', 'default');
        $y = __::get($a, 'foo.baz');
        $y2 = __::get($a, 'foo.baz', 'default');
        $y3 = __::get($a, 'foo.baz', function () {
            return 'default_from_callback';
        });
        $z = __::get($a, 'baz.foo.obj');

        // Assert
        $this->assertEquals('ter', $x);
        $this->assertEquals('ter', $x2);
        $this->assertNull($y);
        $this->assertEquals('default', $y2);
        $this->assertEquals('default_from_callback', $y3);
        $this->assertEquals($o, $z);
    }
}
