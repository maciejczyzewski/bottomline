<?php

namespace collections;

/**
 * Returns the values in the collection that pass the truth test.
 *
 * @param array         $array   array to filter
 * @param \Closure|null $closure closure to filter array based on
 *
 * @return array
 *
 */
function filter(array $array, \Closure $closure = null)
{
    return \array_values(\array_filter($array, $closure));
}
