<?php

namespace arrays;

/**
 * prend item or value to an array
 *
 ** __::prepend([1, 2, 3], 4);
 ** // → [4, 1, 2, 3]
 *
 * @param array $array
 * @param null  $value
 *
 * @return array
 *
 */
function prepend(array $array = [], $value = null)
{
    \array_unshift($array, $value);

    return $array;
}
