<?php

namespace arrays;

/**
 * Creates a slice of the provided array with all elements matching the condition
 * removed from the end.
 *
 * **Drop by Primitive Condition**
 *
 * ```php
 * __::dropRightWhile([1, 2, 3, 3], 3);
 * ```
 *
 * **Result**
 *
 * ```php
 * [1, 2]
 * ```
 *
 * **Drop by Callback**
 *
 * ```php
 * __::dropRightWhile([1, 2, 3, 4, 5], static function ($item) {
 *     return $item > 3;
 * });
 * ```
 *
 * **Result**
 *
 * ```php
 * [1, 2, 3]
 * ```
 *
 * @param array                             $input      An array of values.
 * @param \Closure|double|int|string|bool   $condition  Condition to drop by using either a primitive value or a callback
 *
 * @see drop
 * @see dropRight
 * @see dropRightWhile
 *
 * @return array An array containing a subset of the input array with front items matching the condition removed.
 */
function dropRightWhile($input, $condition)
{
    $comparison = is_callable($condition)
        ? $condition
        : static function ($item) use ($condition) {
            return $item === $condition;
        };

    for ($i = count($input) - 1; $i >= 0; $i--) {
        if ($comparison($input[$i])) {
            continue;
        }

        return \array_slice($input, 0, $i + 1);
    }

    return [];
}
