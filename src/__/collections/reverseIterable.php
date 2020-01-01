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
    // $iterable_values = [];
    // if (is_array($iterable)) {
    //     // TODO Use array_reverse?
    //     $iterable_values = $iterable;
    // } else {
    //     // We first read the iterable values to an array.
    //     // We do that as there is no API to read an iterable from end to start
    //     // (because it could be an infinite genrator)
    //     // and that generators can be iterated only once.
    //     // So it seems we indeed need to pull all iterable content into memory
    //     // for reversing it.
    //     foreach ($iterable as $key => $value) {
    //         $iterable_values[$key] = $value;
    //     }
    // }
    $iterable_values = $iterable;
    for (end($iterable_values); ($key = key($iterable_values)) !== null; prev($iterable_values)) {
        yield $key => current($iterable_values);
    }
}
