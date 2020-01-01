<?php

namespace collections;

/**
 * Return the reverse of an array or other foreach-able (Iterable) without making a copy of it.
 *
 * Code (using `yield`) is from mpen and linepogl
 * See https://stackoverflow.com/a/36605605/1956471
 *
 * **Usage**
 *
 * ```php
 * __::reverseIterable([1, 2, 3]);
 * ```
 *
 * **Result**
 *
 * ```
 * Generator([3, 2, 1])
 * ```
 *
 * @param array|iterable|\Traversable $iterable
 * @return \Generator
 */
function reverseIterable($iterable)
{
    // TODO There is an issue with this implementation:
    // as generators can only be iterated only once, going to the end of the iterable
    // exhaust the values, without possibility to rewind them.
    // Also we use functions that are not part of the Traversable API
    // (not even the Iterator API https://www.php.net/manual/en/class.iterator.php),
    // but are restricted to arrays https://www.php.net/manual/en/function.end.php.
    for (end($iterable); ($key = key($iterable)) !== null; prev($iterable)) {
        yield $key => current($iterable);
    }
}
