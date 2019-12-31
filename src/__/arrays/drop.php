<?php

namespace arrays;

/**
 * When a function has the `yield` keyword, the returned value becomes a
 * \Generator. In order to bypass this behavior and allow `drop` to return either
 * an array or a \Generator, this is code is extracted into a separate function.
 *
 * @internal
 *
 * @param iterable $input
 * @param int      $number
 *
 * @return \Generator
 */
function dropIterable($input, $number)
{
    $iterator = \__::getIterator($input);

    foreach ($iterator as $i => $item) {
        if ($i < $number) {
            continue;
        }

        yield $iterator->current();
    }
}

/**
 * Creates a slice of array with n elements dropped from the beginning.
 *
 * **Usage**
 *
 * ```php
 * __::drop([0, 1, 3, 5], 2);
 * ```
 *
 * **Result**
 *
 * ```
 * [3, 5]
 * ```
 *
 * @param array|iterable $input  The array or iterable to query.
 * @param int            $number The number of elements to drop.
 *
 * @throws \Exception
 *
 * @return array|\Generator
 */
function drop(/*iterable*/ $input, $number = 1)
{
    if (is_array($input)) {
        return \array_slice($input, $number);
    }

    return dropIterable($input, $number);
}
