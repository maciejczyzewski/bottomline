<?php

namespace collections;

/**
 * Returns the minimum value from the collection. If passed an iterator, min will
 * return min value returned by the iterator.
 *
 * **Usage**
 *
 * ```php
 * __::min([1, 2, 3]);
 * ```
 *
 * **Result**
 *
 * ```
 * 1
 * ```
 *
 * @since 0.2.0 added support for iterables
 *
 * @param iterable $array array of values
 *
 * @return mixed
 */
function bottomline_min($array)
{
    $minValue = null;
    foreach ($array as $value) {
        if ($minValue === null || $value < $minValue) {
            $minValue = $value;
        }
    }
    return $minValue;
}
