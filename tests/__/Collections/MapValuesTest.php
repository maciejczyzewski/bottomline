<?php

namespace __\Test\Collections;

use __;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class MapValuesTest extends TestCase
{
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
}
