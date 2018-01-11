<?php

namespace collections;

/**
 * Checks if predicate returns truthy for all elements of collection.
 *
 * Iteration is stopped once predicate returns falsey.
 * The predicate is invoked with three arguments: (value, index|key, collection).
 *
 ** __::every([1, 3, 4], 'is_int');
 ** // → true
 *
 * @param array|object $collection The collection to iterate over.
 * @param Closure $iterate The function to call for each value.
 *
 * @return bool
 *
 */
function every($collection, $iteratee)
{
    $truthy = true;
    // We could use __::reduce(), but it won't allow us to return preminarily.
    \__::doForEach(
        $collection,
        function ($value, $key, $collection) use(&$truthy, $iteratee) {
            $truthy = $truthy && $iteratee($value, $key, $collection);
            if (!$truthy) return false;
        }
    );
    return $truthy;
}
