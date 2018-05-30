<?php

namespace collections;

/**
 * Returns an array of values by mapping each in collection through the iteratee.
 *
 * **Usage**
 *
 * ```php
 * __::map([1, 2, 3], function($value, $key, $collection) {
 *     return $value * 3;
 * });
 * ```
 *
 * **Result**
 *
 * ```
 * [3, 6, 9]
 * ```
 *
 * @param array|object $collection The collection of values to map over.
 * @param \Closure     $iteratee   The function to apply on each value.
 *
 * @return array
 */
function map($collection, \Closure $iteratee)
{
    $result = [];
    \__::doForEach(
        $collection,
        function ($value, $key, $collection) use (&$result, $iteratee) {
            $result[] = $iteratee($value, $key, $collection);
        }
    );
    return $result;
}
