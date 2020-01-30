<?php

namespace collections;

/**
 * Gets the first element of an array/iterable. Passing n returns the first n elements.
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
 * @since 0.2.0 added support for iterables
 *
 * @param iterable $array array (or any iterable) of values
 * @param int|null $count number of values to return
 *
 * @return array|mixed
 */
function first($array, $count = null)
{
    $i = $count ? $count : 1;
    $values = [];
    foreach ($array as $value) {
        $values[] = $value;
        $i -= 1;
        if ($i <= 0) {
            break;
        }
    }
    return $count ? $values : $values[0];
}
