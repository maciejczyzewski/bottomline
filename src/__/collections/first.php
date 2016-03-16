<?php

namespace collections;

/**
 * Gets the first element of an array. Passing n returns the first n elements.
 *
 * @param array $array of values
 * @param null  $take  number of values to return
 *
 * @return array|mixed
 *
 */
function first($array, $take = null)
{
    if (!$take) {
        return \array_shift($array);
    }

    return \array_splice($array, 0, $take, true);
}
