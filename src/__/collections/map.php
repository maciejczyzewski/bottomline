<?php

namespace collections;

/**
 * Returns an array of values by mapping each in collection through the iterator.
 *
 * @param array    $array array of values
 * @param \Closure $closure closure to mapp based on
 *
 * @return array
 *
 */
function map(array $array, \Closure $closure)
{
    return \array_map($closure, $array);
}
