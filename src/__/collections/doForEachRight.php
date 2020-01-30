<?php

namespace collections;

/**
 * Iterate over elements of the collection, from right to left, and invokes iteratee
 * for each element.
 *
 * The iteratee is invoked with three arguments: (value, index|key, collection).
 * Iteratee functions may exit iteration early by explicitly returning false.
 *
 * **Usage**
 *
 * ```php
 * __::doForEachRight([1, 2, 3], function ($value, $key, $collection) {
 *     print_r($value);
 * });
 * ```
 *
 * **Result**
 *
 * ```
 * (Side effect: print 3, 2, 1)
 * ```
 *
 * @param iterable|\stdClass $collection The collection to iterate over.
 * @param \Closure           $iteratee   The function to call for each value.
 *
 * @return void
 */
function doForEachRight($collection, \Closure $iteratee)
{
    \__::doForEach(\__::reverseIterable($collection), $iteratee);
}
