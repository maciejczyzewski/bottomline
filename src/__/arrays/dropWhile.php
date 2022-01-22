<?php

namespace arrays;

/**
 * In order to return either an array or \Generator from dropWhile, we split out
 * the logic or handling arrays and other traversables.
 *
 * @internal
 *
 * @param \Traversable  $input
 * @param \Closure      $comparison
 *
 * @return \Generator
 */
function dropIterableWhile($input, $comparison)
{
    $dropping = true;
    $iterator = \__::getIterator($input);

    foreach ($iterator as $item) {
        if ($dropping && $comparison($item)) {
            continue;
        }

        yield $item;
    }
}

/**
 * In order to return either an array or \Generator from dropWhile, we split out
 * the logic or handling arrays and other traversables.
 *
 * @internal
 *
 * @param array     $input
 * @param \Closure  $comparison
 *
 * @return array
 */
function dropArrayWhile($input, $comparison)
{
    $count = 0;

    foreach ($input as $item) {
        if (!$comparison($item)) {
            break;
        }

        $count++;
    }

    return \array_slice($input, $count);
}

/**
 * Creates a slice of the provided array with all elements matching the condition
 * removed from the front.
 *
 * **Drop by Primitive Condition**
 *
 * ```php
 * __::dropWhile([1, 1, 2, 3, 4], 1);
 * ```
 *
 * **Result**
 *
 * ```php
 * [2, 3, 4]
 * ```
 *
 * **Drop by Callback**
 *
 * ```php
 * __::dropWhile([1, 2, 3, 4, 5], static function ($item) {
 *     return $item < 3;
 * });
 * ```
 *
 * **Result**
 *
 * ```php
 * [3, 4, 5]
 * ```
 *
 * @param array|iterable                    $input      An array or iterable of values to look through.
 * @param \Closure|double|int|string|bool   $condition  Condition to drop by using either a primitive value or a callback.
 *
 * @see drop
 * @see dropRight
 * @see dropRightWhile
 *
 * @return array|\Generator An array containing a subset of the input array with front
 * items matching the condition removed. If the input was not an array, then a \Generator
 * will be returned.
 */
function dropWhile($input, $condition)
{
    $comparison = is_callable($condition)
        ? $condition
        : static function ($item) use ($condition) {
            return $item === $condition;
        };

    return is_array($input)
        ? dropArrayWhile($input, $comparison)
        : dropIterableWhile($input, $comparison);
}
