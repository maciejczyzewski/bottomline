<?php

namespace collections;

use __;

/**
 * Return the first element that matches the given condition.
 *
 * @since 0.2.1
 *
 * @param array|iterable                  $array
 * @param bool|\Closure|double|int|string $condition
 *
 * @see findIndex
 * @see findLast
 * @see findLastIndex
 * @see where
 *
 * @return mixed|null
 */
function find($array, $condition)
{
    $index = \__::findIndex($array, $condition);

    if ($index === -1) {
        return null;
    }

    return $array[$index];
}
