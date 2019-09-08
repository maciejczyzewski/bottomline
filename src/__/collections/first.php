<?php

namespace collections;

/**
 * Gets the first element of an array. Passing n returns the first n elements.
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
 * @param array|iterable    $array array (or any iterable) of values
 * @param int|null $count number of values to return
 *
 * @return array|mixed
 */
function first($array, $count = null)
{
    // For iterables.
    // https://secure.php.net/manual/en/language.types.iterable.php
    if (!\is_array($array)) {
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
    // TODO array_shift reset the array pointer, which is not properly "functional":
    // this change an implicit state and could create issues in external code.
    // See https://www.php.net/manual/en/function.array-shift.php
    return $count ? \array_slice($array, 0, $count, true) : \array_shift($array);
}
