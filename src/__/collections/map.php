<?php

namespace collections;

/**
 * @internal
 *
 * @param iterable $collection
 * @param \Closure $iteratee
 *
 * @return \Generator
 */
function mapIterable($collection, $iteratee)
{
    foreach ($collection as $key => $item) {
        yield $iteratee($item, $key, $collection);
    }
}

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
 * @since 0.2.0 added support for iterables
 *
 * @param iterable|\stdClass $collection The collection of values to map over.
 * @param \Closure           $iteratee   The function to apply on each value.
 *
 * @return array|\Generator
 */
function map($collection, \Closure $iteratee)
{
    if (is_array($collection) || $collection instanceof \stdClass) {
        return iterator_to_array(mapIterable($collection, $iteratee));
    }

    return mapIterable($collection, $iteratee);
}
