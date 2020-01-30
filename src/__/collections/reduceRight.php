<?php

namespace collections;

/**
 * Reduces `$collection` to a value which is the `$accumulator` result of running
 * each element in `$collection` - from right to left - thru `$iteratee`, where
 * each successive invocation is supplied the return value of the previous.
 *
 * If `$accumulator` is not given, the first element of $collection is used as
 * the initial value.
 *
 * **Usage**
 *
 * ```php
 * __::reduceRight(['a', 'b', 'c'], function ($accumulator, $value, $key, $collection) {
 *     return $accumulator . $value;
 * }, '');
 * ```
 *
 * **Result**
 *
 * ```
 * 'cba'
 * ```
 *
 * @since 0.2.0 added support for iterables
 *
 * @param iterable|\stdClass    $collection  The collection to iterate over.
 * @param \Closure              $iteratee    The function invoked per iteration.
 * @param array|\stdClass|mixed $accumulator The initial value.
 *
 * @return array|\stdClass|mixed Returns the accumulated value.
 */
function reduceRight($collection, \Closure $iteratee, $accumulator = null)
{
    return \__::reduce(\__::reverseIterable($collection), $iteratee, $accumulator);
}
