<?php

namespace arrays;

/**
 * Append an item to array.
 *
 * **Usage**
 *
 * ```php
 * __::append([1, 2, 3], 4);
 * ```
 *
 * **Result**
 *
 * ```
 * [1, 2, 3, 4]
 * ```
 *
 * @param array $array The original array
 * @param mixed $value The new item or value to append
 *
 * @return array
 */
function append(array $array, $value = null)
{
    $array[] = $value;

    return $array;
}
