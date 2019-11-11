<?php

class ArrayAccessible implements ArrayAccess
{
    private $content = [];

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->content);
    }

    public function offsetGet($offset)
    {
        return $this->content[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->content[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->content[$offset]);
    }
}

class CollectionsTest extends \PHPUnit\Framework\TestCase
{
    // ...

    public function testAssign()
    {
        // Arrange
        $a1 = ['color' => ['favorite' => 'red', 'model' => 3, 5], 3];
        $a2 = [10, 'color' => ['favorite' => 'green', 'blue']];
        $b1 = ['a' => 0];
        $b2 = ['a' => 1, 'b' => 2];
        $b3 = ['c' => 3, 'd' => 4];

        // Act
        $x = __::assign($a1, $a2);
        $y = __::assign($b1, $b2, $b3);

        // Assert
        $this->assertEquals(['color' => ['favorite' => 'green', 'blue'], 10], $x);
        $this->assertEquals(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], $y);
    }

    public function testAssignObject()
    {
        // Arrange
        $a1 = (object) ['color' => (object) ['favorite' => 'red', 5]];
        $a2 = (object) [10, 'color' => (object) ['favorite' => 'green', 'blue']];
        $b1 = (object) ['a' => 0];
        $b2 = (object) ['a' => 1, 'b' => 2, 5];
        $b3 = (object) ['c' => 3, 'd' => 4, 6];

        // Act
        $x = __::assign($a1, $a2);
        $y = __::assign($b1, $b2, $b3);

        // Assert
        $this->assertEquals((object) ['color' => (object) ['favorite' => 'green', 'blue'], 10], $x);
        $this->assertEquals((object) ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 6], $y);
    }

    public function testConcat()
    {
        // Arrange
        $a1 = ['color' => ['favorite' => 'red', 5], 3];
        $a2 = [10, 'color' => ['favorite' => 'green', 'blue']];
        $b1 = ['a' => 0];
        $b2 = ['a' => 1, 'b' => 2, 5];
        $b3 = ['c' => 3, 'd' => 4, 6];
        $c1 = [1, 2, 3];
        $c2 = [4, 5];

        // Act
        $x = __::concat($a1, $a2);
        $y = __::concat($b1, $b2, $b3);
        $z = __::concat($c1, $c2);

        // Assert
        $this->assertEquals(['color' => ['favorite' => 'green', 'blue'], 3, 10], $x);
        $this->assertEquals(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 5, 6], $y);
        $this->assertEquals([1, 2, 3, 4, 5], $z);
    }

    public function testConcatObject()
    {
        // Arrange
        $a1 = (object) ['color' => (object) ['favorite' => 'red', 5]];
        $a2 = (object) [10, 'color' => (object) ['favorite' => 'green', 'blue']];
        $b1 = (object) ['a' => 0];
        $b2 = (object) ['a' => 1, 'b' => 2];
        $b3 = (object) ['c' => 3, 'd' => 4];

        // Act
        $x = __::concat($a1, $a2);
        $y = __::concat($b1, $b2, $b3);

        // Assert
        $this->assertEquals((object) ['color' => (object) ['favorite' => 'green', 'blue'], 10], $x);
        $this->assertEquals((object) ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], $y);
    }

    public function testConcatDeep()
    {
        // Arrange
        $a1 = ['color' => ['favorite' => 'red', 5], 3];
        $a2 = [10, 'color' => ['favorite' => 'green', 'blue']];
        $b1 = ['a' => 0];
        $b2 = ['a' => 1, 'b' => 2];
        $b3 = ['c' => 3, 'd' => 4];

        // Act
        $x = __::concatDeep($a1, $a2);
        $y = __::concatDeep($b1, $b2, $b3);

        // Assert
        $this->assertEquals(['color' => ['favorite' => ['red', 'green'], 5, 'blue'], 3, 10], $x);
        $this->assertEquals(['a' => [0, 1], 'b' => 2, 'c' => 3, 'd' => 4], $y);
    }

    public function testConcatDeepObject()
    {
        // Arrange
        $a1 = (object) ['color' => (object) ['favorite' => 'red', 5]];
        $a2 = (object) [10, 'color' => (object) ['favorite' => 'green', 'blue']];
        $b1 = (object) ['a' => 0];
        $b2 = (object) ['a' => 1, 'b' => 2];
        $b3 = (object) ['c' => 3, 'd' => 4];

        // Act
        $x = __::concatDeep($a1, $a2);
        $y = __::concatDeep($b1, $b2, $b3);

        // Assert
        $this->assertEquals((object) ['color' => (object) ['favorite' => ['red', 'green'], 5, 'blue'], 10], $x);
        $this->assertEquals((object) ['a' => [0, 1], 'b' => 2, 'c' => 3, 'd' => 4], $y);
    }

    public function testEase()
    {
        $object = new \stdClass();
        // Arrange
        $a = ['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']];
        $b = ['foo' => ['bar' => $object], 'baz' => ['b', 'z']];

        // Act
        $x = __::ease($a);
        $y = __::ease($b);

        // Assert
        $this->assertEquals(3, count($x));
        $this->assertEquals(['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z'], $x);
        $this->assertEquals(['foo.bar' => $object, 'baz.0' => 'b', 'baz.1' => 'z'], $y);
    }

    // running this one before __::set() tests also correct inner dependency autoload
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

    public function testFilter()
    {
        // Arrange
        $a = [1, 2, 3, 4, 5];
        $b = [
            ['name' => 'fred',   'age' => 32],
            ['name' => 'maciej', 'age' => 16]
        ];
        $c = [0, 1, false, 2, null, 3, true];

        // Act
        $x = __::filter($a, function ($n) {
            return $n > 3;
        });
        $y = __::filter($b, function ($n) {
            return $n['age'] == 16;
        });
        $z = __::filter($c);

        // Assert
        $this->assertEquals([4, 5], $x);
        $this->assertEquals([$b[1]], $y);
        $this->assertEquals([1, 2, 3, true], $z);
    }

    public function testFilterIterable()
    {
        // Arrange
        $a = new ArrayIterator([1, 2, 3, 4, 5]);
        $b = new ArrayIterator([
            ['name' => 'fred',   'age' => 32],
            ['name' => 'maciej', 'age' => 16]
        ]);
        $c = new ArrayIterator([0, 1, false, 2, null, 3, true]);

        // Act
        $x = __::filter($a, function ($n) {
            return $n > 3;
        });
        $y = __::filter($b, function ($n) {
            return $n['age'] == 16;
        });
        $z = __::filter($c);

        // Assert
        $this->assertEquals([4, 5], $x);
        $this->assertEquals([$b[1]], $y);
        $this->assertEquals([1, 2, 3, true], $z);
    }

    public function testFirst()
    {
        // Arrange
        $a = [1, 2, 3, 4, 5];

        // Act
        $x = __::first($a);
        $y = __::first($a, 2);

        // Assert
        $this->assertEquals(1, $x);
        $this->assertEquals([1, 2], $y);
    }

    public function testFirstIterable()
    {
        if (version_compare(PHP_VERSION, '7.1', '<')) {
            return;
        }
        // Arrange
        $a = new ArrayIterator([1, 2, 3, 4, 5]);

        // Act
        $x = __::first($a);
        $y = __::first($a, 2);

        // Assert
        $this->assertEquals(1, $x);
        $this->assertEquals([1, 2], $y);
    }

    public function testDoForEach()
    {
        // Arrange
        $makeMapper = function (&$array) {
            return function ($value, $key) use (&$array) {
                $array[$key] = $value;
            };
        };
        $a = [1, 2, 3];
        $b = ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'];
        $c = (object) ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'];

        // Act.
        $aMapped = [];
        $bMapped = [];
        $cMapped = [];
        __::doForEach($a, $makeMapper($aMapped));
        __::doForEach($b, $makeMapper($bMapped));
        __::doForEach($c, $makeMapper($cMapped));

        // Assert
        $this->assertEquals($a, $aMapped);
        $this->assertEquals($b, $bMapped);
        $this->assertEquals($c, (object) $cMapped);
        $this->assertEquals((array) $c, $cMapped);
    }

    public function testDoForEachRight()
    {
        // Arrange
        $makeAppend = function (&$array) {
            return function ($value) use (&$array) {
                $array[] = $value;
            };
        };
        $makeMapper = function (&$array) {
            return function ($value, $key) use (&$array) {
                $array[$key] = $value;
            };
        };
        $a = [1, 2, 3];
        $b = ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'];

        // Act.
        $aAppend = [];
        $aMapped = [];
        $bMapped = [];
        __::doForEachRight($a, $makeAppend($aAppend));
        __::doForEachRight($a, $makeMapper($aMapped));
        __::doForEachRight($b, $makeMapper($bMapped));

        // Assert
        $this->assertEquals(array_reverse($a), $aAppend);
        $this->assertEquals($a, $aMapped);
        $this->assertEquals($b, $bMapped);
    }

    public function testEvery()
    {
        // Arrange.
        $a = [true, 1, null, 'yes'];
        $b = [true, false];
        $c = [1, 3, 4];

        // Act.
        $x = __::every($a, function ($v) {
            return is_bool($v);
        });
        $y = __::every($b, function ($v) {
            return is_bool($v);
        });
        $z = __::every($c, function ($v) {
            return is_int($v);
        });

        // Assert
        $this->assertFalse($x);
        $this->assertTrue($y);
        $this->assertTrue($z);
    }

    public function testDoForEachPrematureReturn()
    {
        // Arrange
        $makeMapper = function (&$array, $returnAtKey) {
            return function ($value, $key) use (&$array, $returnAtKey) {
                $array[$key] = $value;
                if ($returnAtKey === $key) {
                    return false;
                }
            };
        };
        $a = [1, 2, 3, 4];
        $b = ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'];

        // Act.
        $aMapped = [];
        $bMapped = [];
        __::doForEach($a, $makeMapper($aMapped, 1));
        __::doForEach($b, $makeMapper($bMapped, 'city'));

        // Assert
        $this->assertEquals([1, 2], $aMapped);
        $this->assertEquals(['state' => 'IN', 'city' => 'Indianapolis'], $bMapped);
    }

    public function testGetArrays()
    {
        // Arrange
        $o = new \stdClass();
        $a = [
            'foo' => ['bar' => 'ter'],
            'baz' => ['foo' => ['obj' => $o]]
        ];

        // Act
        $x  = __::get($a, 'foo.bar');
        $x2 = __::get($a, 'foo.bar', 'default');
        $y  = __::get($a, 'foo.baz');
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
        $x  = __::get($a, 'foo.bar');
        $x2 = __::get($a, 'foo.bar', 'default');
        $y  = __::get($a, 'foo.baz');
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

    public function testGroupByString()
    {
        $a = [
            ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
            ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
            ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
            ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
            ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
        ];

        $grouped = __::groupBy($a, 'state');
        $this->assertCount(2, $grouped);
        $this->assertArrayHasKey('CA', $grouped);
    }

    public function testGroupByStringMultipleGroupings()
    {
        $a = [
            ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
            ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
            ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
            ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
            ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
        ];

        $grouped = __::groupBy($a, 'state', 'city');
        $this->assertCount(2, $grouped);
        $this->assertCount(2, $grouped['IN']);
        $this->assertArrayHasKey('Indianapolis', $grouped['IN']);
    }

    public function testGroupByNestedValues()
    {
        $a = [
            ['object' => 'School bus', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
            ['object' => 'Manhole', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
            ['object' => 'Basketball', 'metadata' => ['state' => 'IN', 'city' => 'Plainfield']],
            ['object' => 'Light bulb', 'metadata' => ['state' => 'CA', 'city' => 'San Diego']],
            ['object' => 'Space pen', 'metadata' => ['state' => 'CA', 'city' => 'Mountain View']],
        ];

        $grouped = __::groupBy($a, 'metadata.state');
        $this->assertEquals([
            'IN' => [
                ['object' => 'School bus', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
                ['object' => 'Manhole', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
                ['object' => 'Basketball', 'metadata' => ['state' => 'IN', 'city' => 'Plainfield']],
            ],
            'CA' => [
                ['object' => 'Light bulb', 'metadata' => ['state' => 'CA', 'city' => 'San Diego']],
                ['object' => 'Space pen', 'metadata' => ['state' => 'CA', 'city' => 'Mountain View']],
            ],
        ], $grouped);
    }

    public function testGroupByNestedValuesMultipleGrouping()
    {
        $a = [
            ['object' => 'School bus', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
            ['object' => 'Manhole', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
            ['object' => 'Basketball', 'metadata' => ['state' => 'IN', 'city' => 'Plainfield']],
            ['object' => 'Light bulb', 'metadata' => ['state' => 'CA', 'city' => 'San Diego']],
            ['object' => 'Space pen', 'metadata' => ['state' => 'CA', 'city' => 'Mountain View']],
        ];

        $grouped = __::groupBy($a, 'metadata.state', 'metadata.city');
        $this->assertEquals([
            'IN' => [
                'Indianapolis' => [
                    ['object' => 'School bus', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
                    ['object' => 'Manhole', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
                ],
                'Plainfield' => [
                    ['object' => 'Basketball', 'metadata' => ['state' => 'IN', 'city' => 'Plainfield']],
                ],
            ],
            'CA' => [
                'San Diego' => [
                    ['object' => 'Light bulb', 'metadata' => ['state' => 'CA', 'city' => 'San Diego']],
                ],
                'Mountain View' => [
                    ['object' => 'Space pen', 'metadata' => ['state' => 'CA', 'city' => 'Mountain View']],
                ],
            ],
        ], $grouped);
    }

    public function testGroupByInteger()
    {
        $a = [
            ['IN', 'Indianapolis', 'School bus'],
            ['IN', 'Indianapolis', 'Manhole'],
            ['IN', 'Plainfield', 'Basketball'],
            ['CA', 'San Diego', 'Light bulb'],
            ['CA', 'Mountain View', 'Space pen'],
        ];

        $grouped = __::groupBy($a, 1);
        $this->assertCount(4, $grouped);
        $this->assertArrayHasKey('Indianapolis', $grouped);
    }

    public function testGroupByObjectProperties()
    {
        $a = [
            (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
            (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
            (object)['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
            (object)['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
            (object)['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
        ];

        $grouped = __::groupBy($a, 'state');
        $this->assertCount(2, $grouped);
        $this->assertArrayHasKey('CA', $grouped);
    }

    public function testGroupByCallable()
    {
        $a = [
            (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
            (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
            (object)['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
            (object)['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
            (object)['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
        ];

        $grouped = __::groupBy($a, function ($value) {
            return $value->city;
        });
        $this->assertCount(4, $grouped);
        $this->assertArrayHasKey('Indianapolis', $grouped);
    }

    public function testHas()
    {
        // Arrange.
        $a = ['foo' => 'bar'];
        $b = (object) ['foo' => 'bar'];
        $c = ['foo' => ['bar' => 'foie']];
        $d = [5];
        $e = (object) [5];

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
        $a = (object) ['foo' => 'bar'];

        // Act
        $x = __::hasKeys($a, ['foo']);
        $y = __::hasKeys($a, ['foo', 'foz']);

        // Assert
        $this->assertTrue($x);
        $this->assertFalse($y);
    }

    public function testIsEmpty()
    {
        // Assert nominal cases.
        $this->assertTrue(__::isEmpty([]));
        $this->assertFalse(__::isEmpty(['Falcon', 'Heavy']));
        $this->assertTrue(__::isEmpty(new stdClass()));
        $this->assertFalse(__::isEmpty((object) ['Baie' => 'Goji']));
        // Assert on non-collections.
        $this->assertTrue(__::isEmpty(null));
        $this->assertTrue(__::isEmpty(3));
        $this->assertTrue(__::isEmpty(true));
    }

    public function testReveseIterableArray()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::reverseIterable($a, 2);

        // Assert
        // Check we got back a Generator.
        if (version_compare(PHP_VERSION, '5.5.0', '<')) {
            $this->assertTrue(is_array($x));
        } else {
            $this->assertTrue($x instanceof \Generator);
        }
        $xValues = [];
        foreach ($x as $value) {
            $xValues[] = $value;
        }
        $this->assertEquals([3, 2, 1], $xValues);
    }

    public function testReveseIterableArrayIterable()
    {
        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            // Arrange
            $a = new ArrayIterator([1, 2, 3]);

            // Act
            $x = __::reverseIterable($a, 2);

            // Assert
            // Check we got back a Generator.
            $this->assertTrue($x instanceof \Generator);
            $xValues = [];
            foreach ($x as $value) {
                $xValues[] = $value;
            }
            $this->assertEquals([3, 2, 1], $xValues);
        }
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
        $x = __::map($a, function ($n) {
            return $n * 3;
        });

        // Assert
        $this->assertEquals([3, 6, 9], $x);
    }

    public function testMapObject()
    {
        // Arrange
        $a = (object) ['a' => 1, 'b' => 2, 'c' => 3];

        // Act
        $x = __::map($a, function ($n, $key) {
            return $key === 'c' ? $n : $n * 3;
        });

        // Assert
        $this->assertEquals([3, 6, 3], $x);
    }

    public function testMapIterable()
    {
        // Arrange
        $a = new ArrayIterator([1, 2, 3]);

        // Act
        $x = __::map($a, function ($n) {
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

    public function testMaxIterable()
    {
        // Arrange
        $a = new ArrayIterator([1, 2, 3]);

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

    public function testMinIterable()
    {
        // Arrange
        $a = new ArrayIterator([1, 2, 3]);

        // Act
        $x = __::min($a);

        // Assert
        $this->assertEquals(1, $x);
    }

    public function testMerge()
    {
        // Arrange
        $a1 = ['color' => ['favorite' => 'red', 'model' => 3, 5], 3];
        $a2 = [10, 'color' => ['favorite' => 'green', 'blue']];
        $b1 = ['a' => 0];
        $b2 = ['a' => 1, 'b' => 2];
        $b3 = ['c' => 3, 'd' => 4];

        // Act
        $x = __::merge($a1, $a2);
        $y = __::merge($b1, $b2, $b3);

        // Assert
        $this->assertEquals(['color' => ['favorite' => 'green', 'model' => 3, 'blue'], 10], $x);
        $this->assertEquals(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], $y);
    }

    public function testMergeObject()
    {
        // Arrange
        $a1 = (object) ['color' => (object) ['favorite' => 'red', 'model' => 3, 5]];
        $a2 = (object) [10, 'color' => (object) ['favorite' => 'green', 'blue']];
        $b1 = (object) ['a' => 0];
        $b2 = (object) ['a' => 1, 'b' => 2, 5];
        $b3 = (object) ['c' => 3, 'd' => 4, 6];

        // Act
        $x = __::merge($a1, $a2);
        $y = __::merge($b1, $b2, $b3);

        // Assert
        $this->assertEquals((object) ['color' => (object) ['favorite' => 'green', 'model' => 3, 'blue'], 10], $x);
        $this->assertEquals((object) ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 6], $y);
    }

    public function testMergeIterable()
    {
        // Arrange
        $a1 = new ArrayIterator(['color' => ['favorite' => 'red', 'model' => 3, 5], 3]);
        $a2 = new ArrayIterator([10, 'color' => ['favorite' => 'green', 'blue']]);

        // Act
        $x = __::merge($a1, $a2);

        // Assert
        // Check we got back a Generator.
        $this->assertTrue($x instanceof \ArrayIterator);
        $xValues = [];
        foreach ($x as $key => $value) {
            $xValues[$key] = $value;
        }
        $this->assertEquals(['color' => ['favorite' => 'green', 'model' => 3, 'blue'], 10], $xValues);
    }

    public function testPluck()
    {
        // Arrange
        $a = [
            ['foo' => 'bar',  'bis' => 'ter',  '' => 0],
            ['foo' => 'bar2', 'bis' => 'ter2', '' => 1],
        ];

        $b = new \stdClass();
        $b->one = new \stdClass();
        $b->one->foo = 'bar';
        $b->two = new \stdClass();
        $b->two->foo = 'bar2';
        $b->three = new \stdClass();
        $c = [$b->one, $b->two];

        $d = [
            ['foo' => ['bar' => ['baz' => 1]]],
            ['foo' => ['bar' => ['baz' => 2]]]
        ];
        $e = new \stdClass();
        $e->one = new \stdClass();
        $e->one->foo = new \stdClass();
        $e->one->foo->bar = ['baz' => 1];
        $e->two = new \stdClass();
        $e->two->foo = new \stdClass();
        $e->two->foo->bar = new \stdClass();
        $e->two->foo->bar->baz = 2;

        // Act
        $x  = __::pluck($a, 'foo');
        $x2 = __::pluck($a, '');

        $y  = __::pluck($b, 'foo');
        $y2  = __::pluck($c, 'foo');

        $z = __::pluck($d, 'foo.bar.baz');
        $z2 = __::pluck($e, 'foo.bar.baz');

        // Assert
        $this->assertEquals(['bar', 'bar2'], $x);
        $this->assertEquals([0, 1], $x2);

        $this->assertEquals(['bar', 'bar2', null], $y);
        $this->assertEquals(['bar', 'bar2'], $y2);

        $this->assertEquals([1, 2], $z);
        $this->assertEquals([1, 2], $z2);
    }

    public function testReduceArray()
    {
        // Arrange
        $a = [1, 2, 3];
        $b = [
            10659489,
            1578484,
            1620331,
            935440,
            944022,
            1037939,
        ];
        $c = [
            ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
            ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
            ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
            ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
            ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
        ];
        $aReducer = function ($accumulator, $value) {
            return $accumulator + $value;
        };
        $bReducer = function ($accumulator, $value, $index) {
            if ($index === 0) {
                $this->assertEquals(10659489, $accumulator);
            }
            return $accumulator + $value;
        };
        $cIndex = 0;
        $cReducer = function ($accumulator, $value, $index, $collection) use (&$c, &$cIndex) {
            $this->assertEquals($c, $collection);
            $this->assertEquals($cIndex++, $index);
            if (isset($accumulator[$value['city']])) {
                $accumulator[$value['city']]++;
            } else {
                $accumulator[$value['city']] = 1;
            }
            return $accumulator;
        };

        // Act
        $x = __::reduce($a, $aReducer, 2);
        $y = __::reduce($b, $bReducer);
        $z = __::reduce($c, $cReducer, []);

        // Assert
        $this->assertEquals(8, $x);
        $this->assertEquals(27435194, $y);
        $this->assertEquals([
            'Indianapolis' => 2,
            'Plainfield' => 1,
            'San Diego' => 1,
            'Mountain View' => 1,
        ], $z);
    }

    public function testReduceObject()
    {
        // Arrange
        $a = new \stdClass();
        $a->paris = 10659489;
        $a->marseille = 1578484;
        $a->lyon = 1620331;
        $a->toulouse = 935440;
        $a->nice = 944022;
        $a->lille = 1037939;
        $aReducer = function ($accumulator, $value) {
            return $accumulator + $value;
        };
        $b = (object) [
            'a' => 1,
            'b' => 2,
            'c' => 1
        ];
        $bReducer = function ($accumulator, $value, $key) {
            if (!isset($accumulator[$value])) {
                $accumulator[$value] = [];
            }
            $accumulator[$value][] = $key;
            return $accumulator;
        };

        // Act
        $x = __::reduce($a, $aReducer, 0);
        $y = __::reduce($b, $bReducer, []);

        // Assert
        $this->assertEquals(16775705, $x);
        $this->assertEquals([
            '1' => ['a', 'c'],
            '2' => ['b']
        ], $y);
    }

    public function testReduceIterable()
    {
        
        // Arrange
        $a = new ArrayIterator([1, 2, 3]);
        $aReducer = function ($accumulator, $value) {
            return $accumulator + $value;
        };

        // Act
        $x = __::reduce($a, $aReducer, 2);

        // Assert
        $this->assertEquals(8, $x);
    }

    public function testReduceRightArray()
    {
        // Arrange
        $a = ['a', 'b', 'c'];
        $aReducer = function ($word, $char) {
            return $word . $char;
        };

        // Act
        $x = __::reduceRight($a, $aReducer, '');

        // Assert
        $this->assertEquals('cba', $x);
    }

    public function testReduceRightIterable()
    {
        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            // Arrange
            $a = new ArrayIterator(['a', 'b', 'c']);
            $aReducer = function ($word, $char) {
                return $word . $char;
            };

            // Act
            $x = __::reduceRight($a, $aReducer, '');

            // Assert
            $this->assertEquals('cba', $x);
        }
    }

    public function testPick()
    {
        // Arrange
        $a = ['a' => 1, 'b' => ['c' => 3, 'd' => 4], 'h' => 5];

        // Act
        $x = __::pick($a, ['a', 'b.d', 'e', 'f.g']);

        // Assert
        $this->assertEquals([
            'a' => 1,
            'b' => ['d' => 4],
            'e' => null,
            'f' => ['g' => null]
        ], $x);
    }

    public function testPickDefaults()
    {
        // Arrange.
        $a = ['nasa' => 1, 'cnsa' => 42];
        $b = ['a' => 1, 'b' => ['c' => 3, 'd' => 4]];

        // Act.
        $x = __::pick($a, ['cnsa', 'esa', 'jaxa'], 26);
        $y = __::pick($b, ['a', 'b.d', 'e', 'f.g'], 'default');

        // Assert.
        $this->assertEquals([
            'cnsa' => 42,
            'esa' => 26,
            'jaxa' => 26,
        ], $x);
        $this->assertEquals([
            'a' => 1,
            'b' => ['d' => 4],
            'e' => 'default',
            'f' => ['g' => 'default']
        ], $y);
    }

    public function testPickObject()
    {
        // Arrange.
        $a = new \stdClass();
        $a->paris = 10659489;
        $a->marseille = 1578484;
        $a->lyon = 1620331;

        // Act.
        $x = __::pick($a, ['marseille', 'london']);

        // Assert.
        $this->assertEquals((object) [
            'marseille' => 1578484,
            'london' => null
        ], $x);
    }

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
        $a = (object) ['foo' => (object) ['bar' => 'ter']];

        // Act.
        $x = __::set($a, 'foo.baz.ber', 'fer');
        $y = __::set($a, 'foo.bar', 'fer2');

        // Assert.
        $this->assertEquals((object )['foo' => (object) ['bar' => 'ter']], $a);
        $this->assertEquals((object) ['ber' => 'fer'], $x->foo->baz);
        $this->assertEquals((object) ['foo' => (object) ['bar' => 'fer2']], $y);
    }

    public function testSetOveride()
    {
        // Arrange
        $a = ['foo' => ['bar' => 'ter']];

        // Act
        $x = __::set($a, 'foo.bar.not_exist', 'baz');

        // Assert.
        $this->assertEquals(['foo' => ['bar' => 'ter']], $a);
        $this->assertEquals(['foo' => ['bar' => ['not_exist' => 'baz']]], $x);
    }

    public function testWhere()
    {
        // Arrange
        $a = [
            ['name' => 'fred',   'age' => 32],
            ['name' => 'maciej', 'age' => 16],
            ['a' => 'b', 'c' => 'd']
        ];

        // Act
        $x = __::where($a, ['age' => 16]);
        $x2 = __::where($a, ['age' => 16, 'name' => 'fred']);
        $x3 = __::where($a, ['name' => 'maciej', 'age' => 16]);
        $x4 = __::where($a, ['name' => 'unknown']);

        // Assert
        $this->assertEquals([$a[1]], $x);
        $this->assertEquals([], $x2);
        $this->assertEquals([$a[1]], $x3);
        $this->assertEquals([], $x4);
    }

    public function testMapKeys()
    {
        // Arrange
        $a = [
            'name1' => [
                'name' => 'Tuan',
                'age' => 26
            ],
            'name2' => [
                'name' => 'Nguyen',
                'age' => '25'
            ],
        ];

        // Act
        $b = __::mapKeys($a, function ($key) {
            return strtoupper($key);
        });

        // Assert
        $this->assertEquals([
            'NAME1' => [
                'name' => 'Tuan',
                'age' => 26
            ],
            'NAME2' => [
                'name' => 'Nguyen',
                'age' => '25'
            ],
        ], $b);

        // test with complicated closure
        // Act
        $b = __::mapKeys($a, function ($key, $value, $collection) {
            $size = count($collection);
            return "{$key}_{$value['name']}_{$size}";
        });

        // Assert
        $this->assertEquals([
            'name1_Tuan_2' => [
                'name' => 'Tuan',
                'age' => 26
            ],
            'name2_Nguyen_2' => [
                'name' => 'Nguyen',
                'age' => '25'
            ],
        ], $b);

        // test when closure is null, the returned array should have the same data with the original array
        // Act
        $b = __::mapKeys($a);

        // Assert
        $this->assertEquals($a, $b);
    }

    public function testMapKeysInvalidClosure()
    {
        if (method_exists($this, 'expectException')) {
            // new phpunit
            $this->expectException('\Exception', 'closure must returns a number or string');
        } else {
            // old phpunit
            $this->setExpectedException('\Exception', 'closure must returns a number or string');
        }

        // Arrange
        $a = ['x' => ['y' => 1]];

        // Act
        __::mapKeys($a, function ($key) {
            return ['key' => $key];
        });
    }

    public function testMapKeysIterable()
    {
        // Arrange
        $a = new ArrayIterator([
            'name1' => [
                'name' => 'Tuan',
                'age' => 26
            ],
            'name2' => [
                'name' => 'Nguyen',
                'age' => '25'
            ],
        ]);

        // Act
        $b = __::mapKeys($a, function ($key) {
            return strtoupper($key);
        });

        // Assert
        $this->assertEquals([
            'NAME1' => [
                'name' => 'Tuan',
                'age' => 26
            ],
            'NAME2' => [
                'name' => 'Nguyen',
                'age' => '25'
            ],
        ], $b);
    }

    public function testMapValues()
    {
        // Arrange
        $a = [
            'name1' => [
                'name' => 'Tuan',
                'age' => 26
            ],
            'name2' => [
                'name' => 'Nguyen',
                'age' => '25'
            ],
        ];

        // Act
        $b = __::mapValues($a, function ($value) {
            return array_flip($value);
        });

        // Assert
        $this->assertEquals([
            'name1' => [
                'Tuan' => 'name',
                26 => 'age'
            ],
            'name2' => [
                'Nguyen' => 'name',
                25 => 'age'
            ],
        ], $b);

        // test with complicated closure
        // Act
        $b = __::mapValues($a, function ($value, $key, $collection) {
            $size = count($collection);
            return [
                'subKey' => "{$value['age']}_{$key}_{$size}"
            ];
        });

        // Assert
        $this->assertEquals([
            'name1' => ['subKey' => '26_name1_2'],
            'name2' => ['subKey' => '25_name2_2'],
        ], $b);

        // test when closure is null, the returned array should have the same data with the original array
        // Act
        $b = __::mapValues($a);

        // Assert
        $this->assertEquals($a, $b);
    }

    public function testMapValuesIterable()
    {
        // Arrange
        $a = new ArrayIterator([
            'name1' => [
                'name' => 'Tuan',
                'age' => 26
            ],
            'name2' => [
                'name' => 'Nguyen',
                'age' => '25'
            ],
        ]);

        // Act
        $b = __::mapValues($a, function ($value) {
            return array_flip($value);
        });

        // Assert
        $this->assertEquals([
            'name1' => [
                'Tuan' => 'name',
                26 => 'age'
            ],
            'name2' => [
                'Nguyen' => 'name',
                25 => 'age'
            ],
        ], $b);
    }
}
