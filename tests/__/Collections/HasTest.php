<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\ArrayAccessible;
use PHPUnit\Framework\TestCase;

class HasTest extends TestCase
{
    public function testHas()
    {
        // Arrange.
        $a = ['foo' => 'bar'];
        $b = (object)['foo' => 'bar'];
        $c = ['foo' => ['bar' => 'foie']];
        $d = [5];
        $e = (object)[5];

        // Act.
        $x = __::has($a, 'foo');
        $y = __::has($a, 'foz');
        $z = __::has($b, 'foo');
        $xa = __::has($b, 'foz');
        $xb = __::has($c, 'foo.bar');
        $xc = __::has($d, 0);
        $xd = __::has($e, 0);

        // Assert.
        $this->assertTrue($x);
        $this->assertFalse($y);
        $this->assertTrue($z);
        $this->assertFalse($xa);
        $this->assertTrue($xb);
        $this->assertTrue($xc);
        $this->assertTrue($xd);
    }

    public function testHasArrayAccess()
    {
        $aa = new ArrayAccessible();
        $aa['qux'] = true;
        $aa['field'] = null;

        $this->assertTrue(__::has($aa, 'qux'));
        $this->assertTrue(__::has($aa, 'field'));
        $this->assertFalse(__::has($aa, 'non-existent'));
    }
}
