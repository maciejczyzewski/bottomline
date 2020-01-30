<?php

namespace collections;

/**
 * Checks if predicate returns truthy for all elements of collection.
 *
 * Iteration is stopped once predicate returns falsey.
 *
 * **Usage**
 *
 * ```php
 * __::every([1, 3, 4], function ($value, $key, $collection) {
 *     return is_int($v);
 * });
 * ```
 *
 * **Result**
 *
 * ```
 * true
 * ```
 *
 * @param iterable|\stdClass $collection The collection to iterate over.
 * @param \Closure           $iteratee   The function to call for each value.
 *
 * @return bool
 */
function every($collection, \Closure $iteratee)
{
    $truthy = true;

    // We could use __::reduce(), but it won't allow us to return preliminarily.
    \__::doForEach(
        $collection,
        function ($value, $key, $collection) use (&$truthy, $iteratee) {
            $truthy = $truthy && $iteratee($value, $key, $collection);
            if (!$truthy) {
                return false;
            }
        }
    );

    return $truthy;
}
