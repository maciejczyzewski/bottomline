<?php

class CollectionsTest extends PHPUnit_Framework_TestCase
{
    // ...

    public function testEase()
    {
        // Arrange
        $a = ['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']];

        // Act
        $x = __::ease($a);

        // Assert
        $this->assertEquals(3, count($x));
        $this->assertEquals(['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z'], $x);
    }

    public function testFilter()
    {
        // Arrange
        $a = [1, 2, 3, 4, 5];
        $b = [
            ['name' => 'fred',   'age' => 32],
            ['name' => 'maciej', 'age' => 16]
        ];

        // Act
        $x = __::filter($a, function($n) {
            return $n > 3;
        });
        $y = __::filter($b, function($n) {
            return $n['age'] == 16;
        });

        // Assert
        $this->assertEquals([4, 5], $x);
        $this->assertEquals([$b[1]], $y);
    }

    public function testFirst()
    {
        // Arrange
        $a = [1, 2, 3, 4, 5];

        // Act
        $x = __::first($a, 2);

        // Assert
        $this->assertEquals([1, 2], $x);
    }

    public function testGet()
    {
        // Arrange
        $a = ['foo' => ['bar' => 'ter']];

        // Act
        $x = __::get($a, 'foo.bar');

        // Assert
        $this->assertEquals('ter', $x);
    }

    public function testHasKeys()
    {
        // Arrange
        $a = ['foo' => 'bar'];

        // Act
        $x = __::hasKeys($a, ['foo', 'foz'], false);
        $y = __::hasKeys($a, ['foo', 'foz'], true);

        // Assert
        $this->assertFalse($x);
        $this->assertFalse($y);

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

    public function testLast()
    {
        // Arrange
        $a = [1, 2, 3, 4, 5];

        // Act
        $x = __::last($a, 2);
        $y = __::last($a);

        // Assert
        $this->assertEquals([4, 5], $x);
        $this->assertEquals(5, $y);
    }

    public function testMap()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::map($a, function($n) {
            return $n * 3;
        });

        // Assert
        $this->assertEquals([3, 6, 9], $x);
    }

    public function testMax()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::max($a);

        // Assert
        $this->assertEquals(3, $x);
    }


    public function testMin()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::min($a);

        // Assert
        $this->assertEquals(1, $x);
    }

    public function testPluck()
    {
        // Arrange
        $a = [
            ['foo' => 'bar',  'bis' => 'ter' ],
            ['foo' => 'bar2', 'bis' => 'ter2'],
        ];

        // Act
        $x = __::pluck($a, 'foo');

        // Assert
        $this->assertEquals(['bar', 'bar2'], $x);
    }

    public function testSet()
    {
        // Arrange
        $a = [
            ['foo' => ['bar' => 'ter']]
        ];

        // Act
        $x = __::set($a, 'foo.baz.ber', 'fer');

        // Assert
        $this->assertEquals(['ber' => 'fer'], $x['foo']['baz']);
    }

    public function testSetStrictException()
    {
        if (method_exists($this, 'expectException')) {
            // new phpunit
            $this->expectException('\Exception');
        } else {
            // old phpunit
            $this->setExpectedException('\Exception');
        }

        // Arrange
        $a = [
            'foo' => ['bar' => 'ter']
        ];

        // Act
        __::set($a, 'foo.bar.not_exist', 'baz', true);
    }

    public function testUnease()
    {
        // Arrange
        $a = ['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z'];

        // Act
        $x = __::unease($a);

        // Assert
        $this->assertEquals(2, count($x));
        $this->assertEquals(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']], $x);
    }

    public function testWhere()
    {
        // Arrange
        $a = [
            ['name' => 'fred',   'age' => 32],
            ['name' => 'maciej', 'age' => 16]
        ];

        // Act
        $x = __::where($a, ['age' => 16]);

        // Assert
        $this->assertEquals([$a[1]], $x);
    }

    // ...
}