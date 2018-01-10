<?php

namespace arrays;

/**
 * Creates a slice of array with n elements dropped from the beginning.
 *
 ** __::drop([0, 1, 3], 2);
 ** // → [3]
 *
 * @param array $input The array to query.
 * @param int $number The number of elements to drop.
 *
 * @return array
 *
 */
function drop(array $input, $number = 1)
{
    return array_slice($input, $number);
}
