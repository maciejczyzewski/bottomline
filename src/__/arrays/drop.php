<?php

namespace arrays;

/**
 * When a function has the `yield` keyword, the returned value becomes a
 * \Generator. In order to bypass this behavior and allow `drop` to return either
 * an array or a \Generator, this is code is extracted into a separate function.
 *
 * @internal
 *
 * @param \Traversable $input
 * @param int          $number
 *
 * @return \Generator
 */
function dropIterable($input, $number)
{
    // We have our own counter for elements since iterators and generators can
    // return arbitrary keys.
    //
    //   https://www.php.net/manual/en/iterator.key.php
    //   https://www.php.net/manual/en/language.generators.syntax.php#control-structures.yield.associative
    $count = 0;
    $iterator = \__::getIterator($input);

    foreach ($iterator as $item) {
        ++$count;

        if ($count <= $number) {
            continue;
        }

        yield $item;
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
 * @since 0.2.0 iterable objects are now supported
 *
 * @param iterable $input  The array or iterable to query.
 * @param int      $number The number of elements to drop.
 *
 * @return array|\Generator
 */
function drop($input, $number = 1)
{
    if (is_array($input)) {
        return \array_slice($input, $number);
    }

    return dropIterable($input, $number);
}
