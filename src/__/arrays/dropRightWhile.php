<?php

namespace __\arrays;

/**
 * When a function has the `yield` keyword, the returned value becomes a
 * Generator. In order to bypass this behavior and allow `drop` to return either
 * an array or a Generator, this is code is extracted into a separate function.
 *
 * @internal
 *
 * @param \Traversable $input
 * @param callable     $comparison
 *
 * @return \Generator
 */
function dropIteratorRightWhile($input, $comparison)
{
    $arr = iterator_to_array($input, true);
    $items = dropArrayRightWhile($arr, $comparison);

    foreach ($items as $item) {
        yield $item;
    }
}

/**
 * @internal
 *
 * @param array    $input
 * @param callable $comparison
 *
 * @return array
 */
function dropArrayRightWhile($input, $comparison)
{
    for ($i = count($input) - 1; $i >= 0; $i--) {
        if ($comparison($input[$i])) {
            continue;
        }

        return array_slice($input, 0, $i + 1);
    }

    return [];
}

/**
 * Creates a slice of the provided array with all elements matching the condition
 * removed from the end.
 *
 * If the provided iterator is an array, then an array will be returned.
 * Otherwise, a Generator will be returned. In this latter case, the entire
 * iterable will be buffered in memory. If the iterable contains many
 * elements, then this could cause memory issues.
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
 * @param iterable                          $input      An array of values.
 * @param \Closure|double|int|string|bool   $condition  Condition to drop by using either a primitive value or a callback
 *
 * @see drop
 * @see dropRight
 * @see dropRightWhile
 *
 * @since 0.2.3 added to Bottomline
 *
 * @return array|\Generator An array containing a subset of the input array with front items matching the condition
 * removed. If the provided iterable is not an array, then a Generator will be returned.
 */
function dropRightWhile($input, $condition)
{
    $comparison = is_callable($condition)
        ? $condition
        : static function ($item) use ($condition) {
            return $item === $condition;
        };

    if (is_array($input)) {
        return dropArrayRightWhile($input, $comparison);
    }

    return dropIteratorRightWhile($input, $comparison);
}
