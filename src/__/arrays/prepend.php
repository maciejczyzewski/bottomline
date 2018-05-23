<?php

namespace arrays;

/**
 * Prepend item or value to an array.
 *
 * **Usage**
 *
 * ```php
 * __::prepend([1, 2, 3], 4);
 * ```
 *
 * **Result**
 *
 * ```
 * [4, 1, 2, 3]
 * ```
 *
 * @param array $array
 * @param mixed $value
 *
 * @return array
 */
function prepend(array $array, $value = null)
{
    \array_unshift($array, $value);

    return $array;
}
