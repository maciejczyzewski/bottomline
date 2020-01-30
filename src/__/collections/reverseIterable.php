<?php

namespace collections;

/**
 * Return the reverse of an array or other foreach-able (Iterable).
 *
 * For array it does not make a copy of it; but does make a copy to memory for other
 * traversables.
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
 * @since 0.2.0 added support for iterables
 *
 * @param iterable $iterable
 *
 * @return \Generator
 */
function reverseIterable($iterable)
{
    $iterable_values = is_array($iterable) ? $iterable : \iterator_to_array($iterable, true);
    for (end($iterable_values); ($key = key($iterable_values)) !== null; prev($iterable_values)) {
        yield $key => current($iterable_values);
    }
}
