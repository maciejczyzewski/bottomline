<?php

namespace __\Test;

use __;
use __\Test\Utilities\Generators;
use __\Test\Utilities\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class CollectionsTest extends TestCase
{
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
        $a1 = (object)['color' => (object)['favorite' => 'red', 5]];
        $a2 = (object)[10, 'color' => (object)['favorite' => 'green', 'blue']];
        $b1 = (object)['a' => 0];
        $b2 = (object)['a' => 1, 'b' => 2, 5];
        $b3 = (object)['c' => 3, 'd' => 4, 6];

        // Act
        $x = __::assign($a1, $a2);
        $y = __::assign($b1, $b2, $b3);

        // Assert
        $this->assertEquals((object)['color' => (object)['favorite' => 'green', 'blue'], 10], $x);
        $this->assertEquals((object)['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 6], $y);
    }

    public static function dataProvider_concat()
    {
        return [
            // Test with multiple arrays should return an array
            [
                'sources' => [
                    ['color' => ['favorite' => 'red', 5], 3],
                    [10, 'color' => ['favorite' => 'green', 'blue']],
                ],
                'expected' => ['color' => ['favorite' => 'green', 'blue'], 3, 10],
            ],
            // Test with multiple objects should return an object
            [
                'sources' => [
                    (object)['color' => (object)['favorite' => 'red', 5]],
                    (object)[10, 'color' => (object)['favorite' => 'green', 'blue']],
                ],
                'expected' => (object)['color' => (object)['favorite' => 'green', 'blue'], 10],
            ],
            // Test three objects returns an object
            [
                'sources' => [
                    (object)['a' => 0],
                    (object)['a' => 1, 'b' => 2],
                    (object)['c' => 3, 'd' => 4],
                ],
                'expected' => (object)['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4],
            ],
            // Test arrays and objects mixing together, returns array because 1st element is array
            [
                'sources' => [
                    ['a' => 0],
                    (object)['a' => 1, 'b' => 2],
                    (object)['c' => 3, 'd' => 4],
                ],
                'expected' => ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4],
            ],
            // Test arrays and objects mixing together, returns object because 1st element is object
            [
                'sources' => [
                    (object)['a' => 0],
                    ['a' => 1, 'b' => 2],
                    ['c' => 3, 'd' => 4],
                ],
                'expected' => (object)['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4],
            ],
            [
                'sources' => [
                    ['a' => 0],
                    ['a' => 1, 'b' => 2, 5],
                    ['c' => 3, 'd' => 4, 6],
                ],
                'expected' => ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 5, 6],
            ],
            // Test concat with arrays and iterables
            [
                'sources' => [
                    ['a' => 0],
                    new ArrayIterator(['a' => 1, 'b' => 2, 5]),
                    new MockIteratorAggregate(['c' => 3, 'd' => 4, 6]),
                ],
                'expected' => ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 5, 6],
            ],
            // Test on arrays with no keys just append
            [
                'sources' => [
                    [1, 2, 3],
                    [4, 5],
                ],
                'expected' => [1, 2, 3, 4, 5],
            ],
            // Test iterator with an array
            [
                'sources' => [
                    new ArrayIterator([1, 2, 3]),
                    [4, 5],
                ],
                'expected' => [1, 2, 3, 4, 5],
            ],
            [
                'sources' => [
                    new MockIteratorAggregate([1, 2, 3]),
                    (object)[4, 5],
                ],
                'expected' => [1, 2, 3, 4, 5],
            ],
            // Test generator and array
            [
                'sources' => [
                    call_user_func(function () {
                        yield 1;
                        yield 2;
                        yield 3;
                    }),
                    [4, 5, 6],
                ],
                'expected' => [1, 2, 3, 4, 5, 6],
            ],
            // Test all generators
            [
                'sources' => [
                    call_user_func(function () {
                        yield 1;
                        yield 2;
                        yield 3;
                    }),
                    call_user_func(function () {
                        yield 4;
                        yield 5;
                        yield 6;
                    }),
                    call_user_func(function () {
                        yield 7;
                        yield 8;
                        yield 9;
                    }),
                ],
                'expected' => [1, 2, 3, 4, 5, 6, 7, 8, 9],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_concat
     *
     * @param array $sources
     * @param array $expected
     */
    public function testConcat($sources, $expected)
    {
        $actual = call_user_func_array('__::concat', $sources);

        $this->assertEquals($expected, $actual);
    }

    public static function dataProvider_concatDeep()
    {
        return [
            [
                'sources' => [
                    ['color' => ['favorite' => 'red', 5], 3],
                    [10, 'color' => ['favorite' => 'green', 'blue']],
                ],
                'expected' => ['color' => ['favorite' => ['red', 'green'], 5, 'blue'], 3, 10],
            ],
            [
                'sources' => [
                    ['a' => 0],
                    ['a' => 1, 'b' => 2],
                    ['c' => 3, 'd' => 4],
                ],
                'expected' => ['a' => [0, 1], 'b' => 2, 'c' => 3, 'd' => 4],
            ],
            [
                'sources' => [
                    (object)['color' => (object)['favorite' => 'red', 5]],
                    (object)[10, 'color' => (object)['favorite' => 'green', 'blue']],
                ],
                'expected' => (object)['color' => (object)['favorite' => ['red', 'green'], 5, 'blue'], 10],
            ],
            [
                'sources' => [
                    (object)['a' => 0],
                    (object)['a' => 1, 'b' => 2],
                    (object)['c' => 3, 'd' => 4],
                ],
                'expected' => (object)['a' => [0, 1], 'b' => 2, 'c' => 3, 'd' => 4],
            ],
            [
                'sources' => [
                    new ArrayIterator(['a' => 0]),
                    new ArrayIterator(['a' => 1, 'b' => 2]),
                    new ArrayIterator(['c' => 3, 'd' => 4]),
                ],
                'expected' => ['a' => [0, 1], 'b' => 2, 'c' => 3, 'd' => 4],
            ],
            [
                'sources' => [
                    new MockIteratorAggregate(['color' => (object)['favorite' => 'red', 5]]),
                    (object)[10, 'color' => (object)['favorite' => 'green', 'blue']],
                ],
                'expected' => ['color' => (object)['favorite' => ['red', 'green'], 5, 'blue'], 10],
            ],
            [
                'sources' => [
                    (object)[],
                    call_user_func(function () {
                        yield 'a' => 0;
                    }),
                    call_user_func(function () {
                        yield 'a' => 1;
                        yield 'b' => 2;
                    }),
                    new ArrayIterator(['c' => 3, 'd' => 4]),
                ],
                'expected' => (object)['a' => [0, 1], 'b' => 2, 'c' => 3, 'd' => 4],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_concatDeep
     *
     * @param array $sources
     * @param array $expected
     */
    public function testConcatDeep($sources, $expected)
    {
        $actual = call_user_func_array('__::concatDeep', $sources);

        $this->assertEquals($expected, $actual);
    }

    public static function dataProvider_ease()
    {
        $object = new \stdClass();

        return [
            [
                'source' => ['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']],
                'glue' => '.',
                'expected' => ['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z'],
            ],
            [
                'source' => ['foo' => ['bar' => $object], 'baz' => ['b', 'z']],
                'glue' => '_',
                'expected' => ['foo_bar' => $object, 'baz_0' => 'b', 'baz_1' => 'z'],
            ],
            [
                'source' => new ArrayIterator(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]),
                'glue' => '.',
                'expected' => ['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z'],
            ],
            [
                'source' => new MockIteratorAggregate(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]),
                'glue' => '.',
                'expected' => ['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z'],
            ],
            [
                'source' => call_user_func(function () {
                    yield 'foo' => ['bar' => 'ter'];
                    yield 'baz' => ['b', 'z'];
                }),
                'glue' => '.',
                'expected' => ['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z'],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_ease
     *
     * @param mixed  $source
     * @param string $glue
     * @param array  $expected
     */
    public function testEase($source, $glue, $expected)
    {
        $this->assertEquals($expected, __::ease($source, $glue));
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

    public function testUneaseIterable()
    {
        // Arrange
        $a = new ArrayIterator(['foo.bar' => 'ter', 'baz.0' => 'b', 'baz.1' => 'z']);

        // Act
        $x = __::unease($a);

        // Assert
        $this->assertEquals(2, count($x));
        $this->assertEquals(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']], $x);
    }

    public static function dataProvider_filter()
    {
        return [
            // On arrays.
            [
                'source' => [1, 2, 3, 4, 5],
                'filterFn' => function ($n) {
                    return $n > 3;
                },
                'expected' => [4, 5],
            ],
            [
                'source' => [
                    ['name' => 'fred', 'age' => 32],
                    ['name' => 'maciej', 'age' => 16]
                ],
                'filterFn' => function ($n) {
                    return $n['age'] == 16;
                },
                'expected' => [['name' => 'maciej', 'age' => 16]],
            ],
            [
                'source' => [0, 1, false, 2, null, 3, true],
                'filterFn' => null,
                'expected' => [1, 2, 3, true],
            ],
            // The keys are not preserved by our filter implementation.
            // TODO We could provide an equivalent of https://lodash.com/docs/4.17.15#pickBy
            // for preserving keys on associative arrays.
            // We could also pass a preserveKeys argument, which is more PHPonic and is the way already
            // adopted (eg. chunk).
            [
                'source' => ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5],
                'filterFn' => function ($n) {
                    return $n > 3;
                },
                'expected' => [4, 5],
            ],
            // On iterators.
            [
                'source' => new ArrayIterator([1, 2, 3, 4, 5]),
                'filterFn' => function ($n) {
                    return $n > 3;
                },
                'expected' => Generators::createGeneratorFromIterable([4, 5]),
            ],
            [
                'source' => new ArrayIterator([
                    ['name' => 'fred', 'age' => 32],
                    ['name' => 'maciej', 'age' => 16]
                ]),
                'filterFn' => function ($n) {
                    return $n['age'] == 16;
                },
                'expected' => Generators::createGeneratorFromIterable([['name' => 'maciej', 'age' => 16]]),
            ],
            [
                'source' => new ArrayIterator([0, 1, false, 2, null, 3, true]),
                'filterFn' => null,
                'expected' => Generators::createGeneratorFromIterable([1, 2, 3, true]),
            ],
            // On IteratorAggregate.
            [
                'source' => new MockIteratorAggregate([1, 2, 3, 4, 5]),
                'filterFn' => function ($n) {
                    return $n > 3;
                },
                'expected' => Generators::createGeneratorFromIterable([4, 5]),
            ],
            // Generators.
            [
                'source' => Generators::integerGenerator(10),
                'filterFn' => function ($n) {
                    return $n % 2 === 0;
                },
                'expected' => Generators::createGeneratorFromIterable([0, 2, 4, 6, 8]),
            ],
            [
                // We could theorically filter on an infinite generator.
                'source' => Generators::integerGenerator(),
                'filterFn' => function ($n) {
                    return $n % 2 === 0;
                },
                'expected' => Generators::createGeneratorFromIterable([0, 2, 4, 6, 8]),
                'iterateOnlyOnExpected' => true,
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_filter
     *
     * @param array|\Traversable $source
     * @param \Closure           $filterFn
     * @param array|\Traversable $expected
     * @param bool               $iterateOnlyOnExpected
     */
    public function testFilter($source, $filterFn, $expected, $iterateOnlyOnExpected = false)
    {
        $actual = __::filter($source, $filterFn);

        $this->assertEquals($expected, $actual);
        if ($expected instanceof \Generator) {
            if ($iterateOnlyOnExpected) {
                foreach ($expected as $expectedKey => $expectedValue) {
                    $actualKey = $actual->key();
                    $actualValue = $actual->current();
                    $this->assertEquals($expectedKey, $actualKey);
                    $this->assertEquals($expectedValue, $actualValue);
                    $actual->next();
                }
            } else {
                $this->assertEquals(iterator_to_array($expected, true), iterator_to_array($actual, true));
            }
        }
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
        $c = (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'];

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
        $this->assertEquals($c, (object)$cMapped);
        $this->assertEquals((array)$c, $cMapped);
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
        $aa = new Utilities\ArrayAccessible();
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

    public static function dataProvider_groupBy()
    {
        return [
            // Group by string key
            [
                'source' => [
                    ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                    ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                    ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                    ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                    ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                ],
                'expected' => [
                    'IN' => [
                        ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                        ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                        ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                    ],
                    'CA' => [
                        ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                        ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                    ],
                ],
                'keys' => ['state'],
            ],
            // Iterator group by string key
            [
                'source' => new ArrayIterator([
                    ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                    ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                    ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                    ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                    ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                ]),
                'expected' => [
                    'IN' => [
                        ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                        ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                        ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                    ],
                    'CA' => [
                        ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                        ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                    ],
                ],
                'keys' => ['state'],
            ],
            // IteratorAggregate group by string key
            [
                'source' => new MockIteratorAggregate([
                    ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                    ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                    ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                    ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                    ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                ]),
                'expected' => [
                    'IN' => [
                        ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                        ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                        ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                    ],
                    'CA' => [
                        ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                        ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                    ],
                ],
                'keys' => ['state'],
            ],
            // Generator group by string key
            [
                'source' => call_user_func(function () {
                    yield ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'];
                    yield ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'];
                    yield ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'];
                    yield ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'];
                    yield ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'];
                }),
                'expected' => [
                    'IN' => [
                        ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                        ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                        ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                    ],
                    'CA' => [
                        ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                        ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                    ],
                ],
                'keys' => ['state'],
            ],
            // Group by multiple string keys
            [
                'source' => [
                    ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                    ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                    ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                    ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                    ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                ],
                'expected' => [
                    'IN' => [
                        'Indianapolis' => [
                            ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                            ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                        ],
                        'Plainfield' => [
                            ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                        ],
                    ],
                    'CA' => [
                        'San Diego' => [
                            ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                        ],
                        'Mountain View' => [
                            ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                        ],
                    ],
                ],
                'keys' => ['state', 'city'],
            ],
            // Group by nested values
            [
                'source' => [
                    ['object' => 'School bus', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
                    ['object' => 'Manhole', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
                    ['object' => 'Basketball', 'metadata' => ['state' => 'IN', 'city' => 'Plainfield']],
                    ['object' => 'Light bulb', 'metadata' => ['state' => 'CA', 'city' => 'San Diego']],
                    ['object' => 'Space pen', 'metadata' => ['state' => 'CA', 'city' => 'Mountain View']],
                ],
                'expected' => [
                    'IN' => [
                        ['object' => 'School bus', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
                        ['object' => 'Manhole', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
                        ['object' => 'Basketball', 'metadata' => ['state' => 'IN', 'city' => 'Plainfield']],
                    ],
                    'CA' => [
                        ['object' => 'Light bulb', 'metadata' => ['state' => 'CA', 'city' => 'San Diego']],
                        ['object' => 'Space pen', 'metadata' => ['state' => 'CA', 'city' => 'Mountain View']],
                    ],
                ],
                'keys' => ['metadata.state'],
            ],
            // Group by nested values multiple grouping
            [
                'source' => [
                    ['object' => 'School bus', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
                    ['object' => 'Manhole', 'metadata' => ['state' => 'IN', 'city' => 'Indianapolis']],
                    ['object' => 'Basketball', 'metadata' => ['state' => 'IN', 'city' => 'Plainfield']],
                    ['object' => 'Light bulb', 'metadata' => ['state' => 'CA', 'city' => 'San Diego']],
                    ['object' => 'Space pen', 'metadata' => ['state' => 'CA', 'city' => 'Mountain View']],
                ],
                'expected' => [
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
                ],
                'keys' => ['metadata.state', 'metadata.city'],
            ],
            // Group by integer
            [
                'source' => [
                    ['IN', 'Indianapolis', 'School bus'],
                    ['IN', 'Indianapolis', 'Manhole'],
                    ['IN', 'Plainfield', 'Basketball'],
                    ['CA', 'San Diego', 'Light bulb'],
                    ['CA', 'Mountain View', 'Space pen'],
                ],
                'expected' => [
                    'Indianapolis' => [
                        ['IN', 'Indianapolis', 'School bus'],
                        ['IN', 'Indianapolis', 'Manhole'],
                    ],
                    'Plainfield' => [
                        ['IN', 'Plainfield', 'Basketball'],
                    ],
                    'San Diego' => [
                        ['CA', 'San Diego', 'Light bulb'],
                    ],
                    'Mountain View' => [
                        ['CA', 'Mountain View', 'Space pen'],
                    ],
                ],
                'keys' => [1],
            ],
            // Group by object properties
            [
                'source' => [
                    (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                    (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                    (object)['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                    (object)['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                    (object)['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                ],
                'expected' => [
                    'IN' => [
                        (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                        (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                        (object)['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                    ],
                    'CA' => [
                        (object)['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                        (object)['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                    ],
                ],
                'keys' => ['state'],
            ],
            // Group by callable
            [
                'source' => [
                    (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                    (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                    (object)['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                    (object)['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                    (object)['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                ],
                'expected' => [
                    'Indianapolis' => [
                        (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
                        (object)['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
                    ],
                    'Plainfield' => [
                        (object)['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
                    ],
                    'San Diego' => [
                        (object)['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
                    ],
                    'Mountain View' => [
                        (object)['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
                    ],
                ],
                'keys' => [
                    function ($value) {
                        return $value->city;
                    },
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_groupBy
     *
     * @param iterable                         $source
     * @param array                            $expected
     * @param array<int|float|string|\Closure> $keys
     */
    public function testGroupBy($source, $expected, $keys)
    {
        $params = array_merge([$source], $keys);
        $actual = call_user_func_array('__::groupBy', $params);

        $this->assertEquals($expected, $actual);
    }

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
        $aa = new Utilities\ArrayAccessible();
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
        $a = (object)['foo' => 'bar'];

        // Act
        $x = __::hasKeys($a, ['foo']);
        $y = __::hasKeys($a, ['foo', 'foz']);

        // Assert
        $this->assertTrue($x);
        $this->assertFalse($y);
    }

    public function dataProvider_isEmpty()
    {
        return [
            // Assert nominal cases
            [
                'source' => [],
                'expected' => true,
            ],
            [
                'source' => ['Falcon', 'Heavy'],
                'expected' => false,
            ],
            [
                'source' => new \stdClass(),
                'expected' => true,
            ],
            [
                'source' => (object)['Baie' => 'Goji'],
                'expected' => false,
            ],

            // Assert non-collections
            [
                'source' => null,
                'expected' => true,
            ],
            [
                'source' => 3,
                'expected' => true,
            ],
            [
                'source' => true,
                'expected' => true,
            ],


            // Assert iterators
            [
                'source' => new ArrayIterator([]),
                'expected' => true,
            ],
            [
                'source' => new MockIteratorAggregate([]),
                'expected' => true,
            ],
            [
                'source' => new ArrayIterator([1, 2]),
                'expected' => false,
            ],
            [
                'source' => new MockIteratorAggregate([1, 2]),
                'expected' => false,
            ],
            [
                'source' => call_user_func(function () {
                    yield 1;
                    yield 5;
                }),
                'expected' => false,
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_isEmpty
     *
     * @param mixed $source
     * @param bool  $expected
     */
    public function testIsEmpty($source, $expected)
    {
        $this->assertEquals($expected, __::isEmpty($source));
    }

    public function testReverseIterableArray()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = __::reverseIterable($a);

        // Assert
        // Check we got back a Generator.
        $this->assertTrue($x instanceof \Generator);
        $xValues = [];
        foreach ($x as $value) {
            $xValues[] = $value;
        }
        $this->assertEquals([3, 2, 1], $xValues);

        // Note how the keys have been preserved and inverted.
        // TODO Add an option preserve_keys as array_reverse or iterator_to_array?
        $this->assertEquals([2 => 3, 1 => 2, 0 => 1], iterator_to_array(__::reverseIterable($a)));
        $this->assertEquals([3, 2, 1], iterator_to_array(__::reverseIterable($a), false));
    }

    public function testReverseIterableArrayIterable()
    {
        // Arrange
        $a = new ArrayIterator([1, 2, 3]);

        // Act
        $x = __::reverseIterable($a);

        // Assert
        // Check we got back a Generator.
        $this->assertTrue($x instanceof \Generator);
        $xValues = [];
        foreach ($x as $value) {
            $xValues[] = $value;
        }
        $this->assertEquals([3, 2, 1], $xValues);
    }

    public static function dataProvider_last()
    {
        return [
            [
                'source' => [1, 2, 3, 4, 5],
                'take' => 2,
                'expected' => [4, 5],
            ],
            [
                'source' => [1, 2, 3, 4, 5],
                'take' => null,
                'expected' => 5,
            ],
            [
                'source' => new MockIteratorAggregate([1, 2, 3, 4, 5]),
                'take' => 3,
                'expected' => [3, 4, 5],
            ],
            [
                'source' => new ArrayIterator([1, 2, 3, 4, 5]),
                'take' => 4,
                'expected' => [2, 3, 4, 5],
            ],
            [
                'source' => call_user_func(function () {
                    yield 1;
                    yield 2;
                    yield 3;
                    yield 4;
                    yield 5;
                }),
                'take' => 2,
                'expected' => [4, 5],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_last
     *
     * @param iterable $source
     * @param int|null $take
     * @param array    $expected
     */
    public function testLast($source, $take, $expected)
    {
        $actual = __::last($source, $take);

        $this->assertEquals($expected, $actual);
    }

    public static function dataProvider_map()
    {
        return [
            [
                'source' => [1, 2, 3],
                'closure' => function ($n) {
                    return $n * 3;
                },
                'isGenerator' => false,
                'expected' => [3, 6, 9],
            ],
            [
                'source' => (object)['a' => 1, 'b' => 2, 'c' => 3],
                'closure' => function ($n, $key) {
                    return $key === 'c' ? $n : $n * 3;
                },
                'isGenerator' => false,
                'expected' => [3, 6, 3],
            ],
            [
                'source' => new ArrayIterator([1, 2, 3]),
                'closure' => function ($n) {
                    return $n * 3;
                },
                'isGenerator' => true,
                'expected' => [3, 6, 9],
            ],
            [
                'source' => new MockIteratorAggregate([1, 2, 3]),
                'closure' => function ($n) {
                    return $n * 6;
                },
                'isGenerator' => true,
                'expected' => [6, 12, 18],
            ],
            [
                'source' => call_user_func(function () {
                    yield 1;
                    yield 2;
                    yield 3;
                }),
                'closure' => function ($n) {
                    return $n * 3;
                },
                'isGenerator' => true,
                'expected' => [3, 6, 9],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_map
     *
     * @param iterable $source
     * @param \Closure $closure
     * @param bool     $isGenerator
     * @param array    $expected
     */
    public function testMap($source, $closure, $isGenerator, $expected)
    {
        $actual = __::map($source, $closure);

        if ($isGenerator) {
            $this->assertInstanceOf(\Generator::class, $actual);
        } else {
            $this->assertTrue(is_array($actual));
        }

        foreach ($actual as $key => $value) {
            $this->assertEquals($expected[$key], $value);
        }
    }

    public static function dataProvider_mapKeys()
    {
        return [
            [
                'source' => [
                    'name1' => [
                        'name' => 'Tuan',
                        'age' => 26
                    ],
                    'name2' => [
                        'name' => 'Nguyen',
                        'age' => '25'
                    ],
                ],
                'closure' => function ($key) {
                    return strtoupper($key);
                },
                'isGenerator' => false,
                'expected' => [
                    'NAME1' => [
                        'name' => 'Tuan',
                        'age' => 26,
                    ],
                    'NAME2' => [
                        'name' => 'Nguyen',
                        'age' => '25',
                    ],
                ],
            ],
            [
                'source' => [
                    'name1' => [
                        'name' => 'Tuan',
                        'age' => 26
                    ],
                    'name2' => [
                        'name' => 'Nguyen',
                        'age' => '25'
                    ],
                ],
                'closure' => function ($key, $value, $collection) {
                    $size = count($collection);

                    return "{$key}_{$value['name']}_{$size}";
                },
                'isGenerator' => false,
                'expected' => [
                    'name1_Tuan_2' => [
                        'name' => 'Tuan',
                        'age' => 26,
                    ],
                    'name2_Nguyen_2' => [
                        'name' => 'Nguyen',
                        'age' => '25',
                    ],
                ],
            ],
            [
                'source' => [
                    'name1' => [
                        'name' => 'Tuan',
                        'age' => 26
                    ],
                    'name2' => [
                        'name' => 'Nguyen',
                        'age' => '25'
                    ],
                ],
                'closure' => null,
                'isGenerator' => false,
                'expected' => [
                    'name1' => [
                        'name' => 'Tuan',
                        'age' => 26
                    ],
                    'name2' => [
                        'name' => 'Nguyen',
                        'age' => '25'
                    ],
                ],
            ],
            [
                'source' => new ArrayIterator([
                    'name1' => [
                        'name' => 'Tuan',
                        'age' => 26
                    ],
                    'name2' => [
                        'name' => 'Nguyen',
                        'age' => '25'
                    ],
                ]),
                'closure' => function ($key) {
                    return strtoupper($key);
                },
                'isGenerator' => true,
                'expected' => [
                    'NAME1' => [
                        'name' => 'Tuan',
                        'age' => 26,
                    ],
                    'NAME2' => [
                        'name' => 'Nguyen',
                        'age' => '25',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_mapKeys
     *
     * @param iterable      $source
     * @param \Closure|null $closure
     * @param bool          $isGenerator
     * @param array         $expected
     */
    public function testMapKeys($source, $closure, $isGenerator, $expected)
    {
        $actual = __::mapKeys($source, $closure);

        if ($isGenerator) {
            $this->assertInstanceOf(\Generator::class, $actual);
        } else {
            $this->assertTrue(is_array($actual));
        }

        foreach ($actual as $key => $item) {
            $this->assertEquals($expected[$key], $item);
        }
    }

    public function testMapKeysInvalidClosure()
    {
        if (method_exists($this, 'expectException')) {
            // new phpunit
            $this->expectException(\Exception::class, 'closure must returns a number or string');
        } else {
            // old phpunit
            $this->setExpectedException(\Exception::class, 'closure must returns a number or string');
        }

        // Arrange
        $a = ['x' => ['y' => 1]];

        // Act
        __::mapKeys($a, function ($key) {
            return ['key' => $key];
        });
    }

    public function dataProvider_mapValues()
    {
        return [
            [
                'source' => [
                    'name1' => [
                        'name' => 'Tuan',
                        'age' => 26
                    ],
                    'name2' => [
                        'name' => 'Nguyen',
                        'age' => '25'
                    ],
                ],
                'closure' => function ($value) {
                    return array_flip($value);
                },
                'isGenerator' => false,
                'expected' => [
                    'name1' => [
                        'Tuan' => 'name',
                        26 => 'age'
                    ],
                    'name2' => [
                        'Nguyen' => 'name',
                        25 => 'age'
                    ],
                ],
            ],
            [
                'source' => [
                    'name1' => [
                        'name' => 'Tuan',
                        'age' => 26
                    ],
                    'name2' => [
                        'name' => 'Nguyen',
                        'age' => '25'
                    ],
                ],
                'closure' => function ($value, $key, $collection) {
                    $size = count($collection);

                    return [
                        'subKey' => "{$value['age']}_{$key}_{$size}"
                    ];
                },
                'isGenerator' => false,
                'expected' => [
                    'name1' => ['subKey' => '26_name1_2'],
                    'name2' => ['subKey' => '25_name2_2'],
                ],
            ],
            [
                'source' => [
                    'name1' => [
                        'name' => 'Tuan',
                        'age' => 26
                    ],
                    'name2' => [
                        'name' => 'Nguyen',
                        'age' => '25'
                    ],
                ],
                'closure' => null,
                'isGenerator' => false,
                'expected' => [
                    'name1' => [
                        'name' => 'Tuan',
                        'age' => 26
                    ],
                    'name2' => [
                        'name' => 'Nguyen',
                        'age' => '25'
                    ],
                ],
            ],
            [
                'source' => new ArrayIterator([
                    'name1' => [
                        'name' => 'Tuan',
                        'age' => 26
                    ],
                    'name2' => [
                        'name' => 'Nguyen',
                        'age' => '25'
                    ],
                ]),
                'closure' => function ($value) {
                    return array_flip($value);
                },
                'isGenerator' => true,
                'expected' => [
                    'name1' => [
                        'Tuan' => 'name',
                        26 => 'age'
                    ],
                    'name2' => [
                        'Nguyen' => 'name',
                        25 => 'age'
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_mapValues
     *
     * @param iterable      $source
     * @param \Closure|null $closure
     * @param bool          $isGenerator
     * @param array         $expected
     */
    public function testMapValues($source, $closure, $isGenerator, $expected)
    {
        $actual = __::mapValues($source, $closure);

        if ($isGenerator) {
            $this->assertInstanceOf(\Generator::class, $actual);
        } else {
            $this->assertTrue(is_array($actual));
        }

        foreach ($actual as $key => $item) {
            $this->assertEquals($expected[$key], $item);
        }
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
        $a1 = (object)['color' => (object)['favorite' => 'red', 'model' => 3, 5]];
        $a2 = (object)[10, 'color' => (object)['favorite' => 'green', 'blue']];
        $b1 = (object)['a' => 0];
        $b2 = (object)['a' => 1, 'b' => 2, 5];
        $b3 = (object)['c' => 3, 'd' => 4, 6];

        // Act
        $x = __::merge($a1, $a2);
        $y = __::merge($b1, $b2, $b3);

        // Assert
        $this->assertEquals((object)['color' => (object)['favorite' => 'green', 'model' => 3, 'blue'], 10], $x);
        $this->assertEquals((object)['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 6], $y);
    }

    public function testMergeIterable()
    {
        // Arrange
        $a1 = new ArrayIterator(['color' => ['favorite' => 'red', 'model' => 3, 5], 3]);
        $a2 = new ArrayIterator([10, 'color' => ['favorite' => 'green', 'blue']]);

        // Act
        $x = __::merge($a1, $a2);

        // Assert
        // Check we got back an array.
        $this->assertTrue(is_array($x));
        $xValues = [];
        foreach ($x as $key => $value) {
            $xValues[$key] = $value;
        }
        $this->assertEquals(new ArrayIterator(['color' => ['favorite' => 'red', 'model' => 3, 5], 3]), $a1);
        $this->assertEquals(new ArrayIterator([10, 'color' => ['favorite' => 'green', 'blue']]), $a2);
        $this->assertEquals(['color' => ['favorite' => 'green', 'model' => 3, 'blue'], 10], $xValues);
    }

    public function testPluck()
    {
        // Arrange
        $a = [
            ['foo' => 'bar', 'bis' => 'ter', '' => 0],
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
        $x = __::pluck($a, 'foo');
        $x2 = __::pluck($a, '');

        $y = __::pluck($b, 'foo');
        $y2 = __::pluck($c, 'foo');

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

    public function testPluckIterable()
    {
        // Arrange
        $a = new ArrayIterator([
            ['foo' => 'bar', 'bis' => 'ter', '' => 0],
            ['foo' => 'bar2', 'bis' => 'ter2', '' => 1],
        ]);

        // Act
        $x = __::pluck($a, 'foo');
        $x2 = __::pluck($a, '');

        // Assert
        $this->assertEquals(['bar', 'bar2'], $x);
        $this->assertEquals([0, 1], $x2);
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
        $b = (object)[
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
        $this->assertEquals((object)[
            'marseille' => 1578484,
            'london' => null
        ], $x);
    }

    public function testPickIterable()
    {
        // Arrange
        $a = new ArrayIterator(['a' => 1, 'b' => ['c' => 3, 'd' => 4], 'h' => 5]);

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
        $aa = new Utilities\ArrayAccessible();

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

    public static function dataProvider_size()
    {
        return [
            [
                'source' => [],
                'expected' => 0,
            ],
            [
                'source' => [1, 2, 3],
                'expected' => 3,
            ],
            [
                'source' => new \stdClass(),
                'expected' => 0,
            ],
            [
                'source' => (object)['hello' => 'world'],
                'expected' => 1,
            ],
            [
                'source' => false,
                'expected' => false,
            ],
            [
                'source' => null,
                'expected' => false,
            ],
            [
                'source' => 3,
                'expected' => false,
            ],
            [
                'source' => new ArrayIterator([]),
                'expected' => 0,
            ],
            [
                'source' => new ArrayIterator([1, 2, 3]),
                'expected' => 3,
            ],
            [
                'source' => new MockIteratorAggregate([]),
                'expected' => 0,
            ],
            [
                'source' => new MockIteratorAggregate([1, 2, 3]),
                'expected' => 3,
            ],
            [
                'source' => call_user_func(function () {
                    yield 1;
                }),
                'expected' => 1,
            ],
            [
                'source' => call_user_func(function () {
                }),
                'expected' => 0,
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_size
     *
     * @param mixed $source
     * @param int   $expected
     */
    public function testSize($source, $expected)
    {
        $this->assertEquals($expected, __::size($source));
    }

    public function testWhere()
    {
        // Arrange
        $a = [
            ['name' => 'fred', 'age' => 32],
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

    public function testWhereIterable()
    {
        // Arrange
        $a = new ArrayIterator([
            ['name' => 'fred', 'age' => 32],
            ['name' => 'maciej', 'age' => 16],
            ['a' => 'b', 'c' => 'd']
        ]);

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
}
