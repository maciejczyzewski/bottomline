<?php

namespace arrays;

/**
 * When a function has the `yield` keyword, the returned value becomes a
 * Generator. In order to bypass this behavior and allow `drop` to return either
 * an array or a Generator, this is code is extracted into a separate function.
 *
 * @internal
 *
 * @param iterable $input
 * @param int $number
 *
 * @return \Generator
 */
function dropRightIterable($input, $number)
{
    $arr = \iterator_to_array($input, true);
    $items = dropRightArray($arr, $number);

    foreach ($items as $item) {
        yield $item;
    }
}

/**
 * @internal
 *
 * @param array $input
 * @param int $number
 *
 * @return array
 */
function dropRightArray($input, $number)
{
    return \array_slice($input, 0, max(count($input) - $number, 0));
}

/**
 * Creates a slice of an array with n elements dropped from the end.
 *
 * If the provided iterator is an array, then an array will be returned.
 * Otherwise, a Generator will be returned. In this latter case, the entire
 * iterable will be buffered in memory. If the iterable contains many
 * elements, then this could cause memory issues.
 *
 * **Usage**
 *
 * ```php
 * __::dropRight([0, 1, 3, 5], 2);
 * ```
 *
 * **Result**
 *
 * ```php
 * [0, 1]
 * ```
 *
 * @param iterable  $input  The array to query.
 * @param int       $number The number of elements to drop.
 *
 * @see drop
 * @see dropWhile
 * @see dropRightWhile
 *
 * @since 0.2.3 added to Bottomline
 *
 * @return array|\Generator An array containing a subset of the input array with front items matching the condition
 * removed. If the provided iterable is not an array, then a Generator will be returned.
 */
function dropRight($input, $number = 1)
{
    if (is_array($input)) {
        return dropRightArray($input, $number);
    }

    return dropRightIterable($input, $number);
}
