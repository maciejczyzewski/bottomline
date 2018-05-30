<?php

namespace collections;

/**
 * Gets the first element of an array. Passing n returns the first n elements.
 *
 * When `$count` is `null`, only the first element will be returned.
 *
 * **Usage**
 *
 * ```php
 * __::first([1, 2, 3, 4, 5], 2);
 * ```
 *
 * **Result**
 *
 * ```
 * [1, 2]
 * ```
 *
 * @param array    $array array of values
 * @param int|null $count number of values to return
 *
 * @return array|mixed
 */
function first(array $array, $count = null)
{
    return $count ? \array_slice($array, 0, $count, true) : \array_shift($array);
}
