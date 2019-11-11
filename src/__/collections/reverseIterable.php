<?php

namespace collections;

if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    eval('
    function iter_reverse($iterable) {
        return array_reverse($iterable, true);
    }
    ');
} else {
    eval('
    function iter_reverse($iterable) {
        for (end($iterable); ($key = key($iterable)) !== null; prev($iterable)) {
            yield $key => current($iterable);
        }
    }
    ');
}

/**
 * Return the reverse of an array or other foreach-able (Iterable) without making a copy of it.
 *
 * Code for PHP_VERSION >= 5.5.(using `yield`) is from mpen and linepogl
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
    return iter_reverse($iterable);
}
