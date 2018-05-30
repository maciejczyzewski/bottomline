<?php

namespace arrays;

/**
 * Creates an array of elements split into groups the length of `$size`.
 *
 * If array can't be split evenly, the final chunk will be the remaining elements.
 * When `$preserveKeys` is set to TRUE, keys will be preserved. Default is FALSE,
 * which will reindex the chunk numerically.
 *
 * **Usage**
 *
 * ```php
 * __::chunk([1, 2, 3, 4, 5], 3);
 * ```
 *
 * **Result**
 *
 * ```
 * [[1, 2, 3], [4, 5]]
 * ```
 *
 * @param array   $array        The original array
 * @param int     $size         The chunk size
 * @param boolean $preserveKeys Whether or not to preserve index keys
 *
 * @return array
 */
function chunk(array $array, $size = 1, $preserveKeys = false)
{
    return \array_chunk($array, $size, $preserveKeys);
}
