<?php

namespace arrays;

/**
 * Append item to array
 *
 ** __::append([1, 2, 3], 4);
 ** // → [1, 2, 3, 4]
 *
 * @param array $array original array
 * @param null  $value new item or valie to append
 *
 * @return array
 *
 */
function append(array $array, $value = null)
{
    $array[] = $value;

    return $array;
}