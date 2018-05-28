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
 * @param array|object       $collection  The collection to iterate over.
 * @param \Closure           $iteratee    The function invoked per iteration.
 * @param array|object|mixed $accumulator The initial value.
 *
 * @return array|object|mixed Returns the accumulated value.
 */
function reduceRight($collection, \Closure $iteratee, $accumulator = null)
{
    // TODO Factorize using iter_reverse: make it a function. (See doForEachRight)
    if ($accumulator === null) {
        $accumulator = \__::first($collection);
    }
    \__::doForEachRight(
        $collection,
        function ($value, $key, $collection) use(&$accumulator, $iteratee) {
            $accumulator = $iteratee($accumulator, $value, $key, $collection);
        }
    );
    return $accumulator;
}
