<?php

namespace collections;

/**
 * Get last item(s) of an array.
 *
 * **Usage**
 *
 * ```php
 * __::last([1, 2, 3, 4, 5], 2);
 * ```
 *
 * **Result**
 *
 * ```
 * [4, 5]
 * ```
 *
 * @since 0.2.0 added support for iterables
 *
 * @param iterable $iterable array of values
 * @param int|null $take     number of returned values
 *
 * @return array|mixed
 */
function last($iterable, $take = null)
{
    $take = (int)$take;

    if (is_array($iterable)) {
        return $take ? \array_slice($iterable, -$take) : \array_pop($iterable);
    }

    $result = [];
    $count = 0;

    \__::doForEachRight($iterable, function ($value) use (&$count, $take, &$result) {
        if ($count++ >= $take) {
            return false;
        }

        $result = \__::prepend($result, $value);
    });

    return $result;
}
