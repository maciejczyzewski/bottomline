<?php

namespace collections;

/**
 * Get last item(s) of an array.
 *
 * **Usage**
 *
 * ```php
 * __::last([1, 2, 3, 4, 5], 2);
 * ```
 *
 * **Result**
 *
 * ```
 * [4, 5]
 * ```
 *
 * @param array    $array array of values
 * @param int|null $take  number of returned values
 *
 * @return array|mixed
 */
function last($array, $take = null)
{
    return $take ? \array_slice($array, -$take) : \array_pop($array);
}
