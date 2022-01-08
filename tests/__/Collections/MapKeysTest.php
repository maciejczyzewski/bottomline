<?php

namespace __\Test\Collections;

use __;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class MapKeysTest extends TestCase
{
    public static function provideMapKeysCases()
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
     * @dataProvider provideMapKeysCases
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
}
