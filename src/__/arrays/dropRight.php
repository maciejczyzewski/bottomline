<?php

namespace arrays;

/**
 * Creates a slice of an array with n elements dropped from the end.
 *
 * **Usage**
 *
 * ```php
 * __::dropRight([0, 1, 3, 5], 2);
 * ```
 *
 * **Result**
 *
 * ```php
 * [0, 1]
 * ```
 *
 * @param array    $input  The array to query.
 * @param int      $number The number of elements to drop.
 *
 * @see drop
 * @see dropWhile
 * @see dropRightWhile
 *
 * @return array
 */
function dropRight($input, $number = 1)
{
    return \array_slice($input, 0, max(count($input) - $number, 0));
}
