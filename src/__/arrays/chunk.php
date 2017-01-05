<?php

namespace arrays;

/**
 * Creates an array of elements split into groups the length of size. If array can't be split evenly, the final chunk will be the remaining elements.
 *
 * __::chunk([1, 2, 3, 4, 5], 3);
 * // → [[1, 2, 3], [4, 5]]
 *
 * @param array   $array        original array
 * @param int     $size         the chunk size
 * @param boolean $preserveKeys When set to TRUE keys will be preserved. Default is FALSE which will reindex the chunk numerically
 *
 * @return array
 *
 */
function chunk(array $array, $size = 1, $preserveKeys = false)
{
    return \array_chunk($array, $size, $preserveKeys);
}
