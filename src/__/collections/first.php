<?php

namespace collections;

/**
 * Gets the first element of an array. Passing n returns the first n elements.
 *
 * @param array    $array array of values
 * @param int|null $take  number of values to return
 *
 * @return array|mixed
 *
 */
function first(array $array, $take = null)
{
    return $take ? \array_slice($array, 0, $take, true) : \array_shift($array);
}
