<?php

namespace __\Test\Collections;

use __;
use __\TestHelpers\Generators;
use __\TestHelpers\MockIteratorAggregate;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
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
}
