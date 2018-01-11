<?php

namespace collections;

/**
 * Returns an array of values by mapping each in collection through the iteratee.
 *
 * The iteratee is invoked with three arguments: (value, index|key, collection).
 *
 * @param array|object $collection The collection of values to map over.
 * @param Closure $iteratee The function to apply on each value.
 *
 * @return array
 *
 */
function map($collection, \Closure $iteratee)
{
    $result = [];
    foreach ($collection as $key => $value) {
        $result[] = $iteratee($value, $key, $collection);
    }
    return $result;
}
