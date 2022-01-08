<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class GroupByTest extends TestCase
{
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
}
