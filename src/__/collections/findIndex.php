<?php

namespace collections;

/**
 * Return the first element that matches the given condition.
 *
 * @param array|iterable                  $array
 * @param bool|\Closure|double|int|string $condition
 *
 * @see find
 * @see findLast
 * @see findLastIndex
 * @see where
 *
 * @since 0.2.1
 *
 * @return int
 */
function findIndex($array, $condition)
{
    if (is_callable($condition)) {
        $comparison = $condition;
    } else {
        $comparison = static function ($value, $_key, $_arr) use ($condition) {
            return $value === $condition;
        };
    }

    foreach ($array as $key => $arrItem) {
        if ($comparison($arrItem, $key, $array)) {
            return $key;
        }
    }

    return -1;
}
