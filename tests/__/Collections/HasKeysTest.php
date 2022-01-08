<?php

namespace __\Test\Collections;

use __;
use PHPUnit\Framework\TestCase;

class HasKeysTest extends TestCase
{
    public function testHasKeys()
    {
        // Arrange
        $a = ['foo' => 'bar'];
        $b = ['foo' => ['bar' => 'foie'], 'estomac' => true];

        // Act
        $x = __::hasKeys($a, ['foo', 'foz'], false);
        $y = __::hasKeys($a, ['foo', 'foz'], true);
        $z = __::hasKeys($b, ['foo.bar', 'estomac']);

        // Assert
        $this->assertFalse($x);
        $this->assertFalse($y);
        $this->assertTrue($z);

        //Rearrange
        $a['foz'] = 'baz';

        //React
        $x = __::hasKeys($a, ['foo', 'foz'], false);
        $y = __::hasKeys($a, ['foo', 'foz'], true);

        // Assert
        $this->assertTrue($x);
        $this->assertTrue($y);

        //Rearrange
        $a['xxx'] = 'bay';

        //React
        $x = __::hasKeys($a, ['foo', 'foz'], false);
        $y = __::hasKeys($a, ['foo', 'foz'], true);

        // Assert
        $this->assertTrue($x);
        $this->assertFalse($y);
    }

    public function testHasKeysObject()
    {
        // Arrange.
        $a = (object)['foo' => 'bar'];

        // Act
        $x = __::hasKeys($a, ['foo']);
        $y = __::hasKeys($a, ['foo', 'foz']);

        // Assert
        $this->assertTrue($x);
        $this->assertFalse($y);
    }
}
