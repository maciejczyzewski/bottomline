<?php

namespace collections;

/**
 * Iterate over elements of the collection and invokes iteratee for each element.
 *
 * The iteratee is invoked with three arguments: (value, index|key, collection).
 * Iteratee functions may exit iteration early by explicitly returning false.
 *
 * **Usage**
 *
 * ```php
 * __::doForEach([1, 2, 3], function ($value, $key, $collection) {
 *     print_r($value)
 * });
 * ```
 *
 * **Result**
 *
 * ```
 * (Side effect: print 1, 2, 3)
 * ```
 *
 * @param iterable|\stdClass $collection The collection to iterate over.
 * @param \Closure           $iteratee   The function to call for each value.
 *
 * @return void
 */
function doForEach($collection, \Closure $iteratee)
{
    foreach ($collection as $key => $value) {
        if ($iteratee($value, $key, $collection) === false) {
            break;
        }
    }
}
