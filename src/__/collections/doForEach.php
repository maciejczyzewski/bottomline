<?php

namespace collections;

/**
 * Iterate over elements of the collection and invokes iteratee for each element.
 *
 * The iteratee is invoked with three arguments: (value, index|key, collection).
 * Iteratee functions may exit iteration early by explicitly returning false.
 *
 ** __::doForEach([1, 2, 3], function ($value) { print_r($value) });
 ** // → (Side effect: print 1, 2, 3)
 *
 * @param array|object $collection The collection to iterate over.
 * @param \Closure $iteratee The function to call for each value.
 *
 * @return null
 *
 */
function doForEach($collection, \Closure $iteratee)
{
    foreach ($collection as $key => $value) {
        if ($iteratee($value, $key, $collection) === false) {
            break;
        }
    }
}
