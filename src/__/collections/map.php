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
function map(array $array = array(), \Closure $closure)
{
    foreach ($array as $key => $value) {
        $array[$key] = $closure($value, $key);
    }

    return $array;
}
