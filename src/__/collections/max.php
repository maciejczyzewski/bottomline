<?php

namespace collections;

/**
 * Returns the maximum value from the collection.
 * If passed an iterator, max will return max value returned by the iterator.
 *
 * **Usage**
 *
 * ```php
 * __::max([1, 2, 3]);
 * ```
 *
 * **Result**
 *
 * ```
 * 3
 * ```
 *
 * @param array|iterable $array array
 *
 * @return mixed maximum value
 */
function bottomline_max($array)
{
    $maxValue = null;
    foreach ($array as $value) {
        if ($maxValue === null || $value > $maxValue) {
            $maxValue = $value;
        }
    }
    return $maxValue;
}
