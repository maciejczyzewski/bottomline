<?php

namespace collections;

/**
 * Returns an array having only keys present in the given path list.
 *
 * Values for missing keys values will be filled with provided default value.
 *
 * **Usage**
 *
 * ```php
 * __::pick(
 *     [
 *         'a' => 1,
 *         'b' => ['c' => 3, 'd' => 4]
 *     ],
 *     ['a', 'b.d']
 * );
 * ```
 *
 * **Result**
 *
 * ```
 * [
 *     'a' => 1,
 *     'b' => ['d' => 4]
 * ]
 * ```
 *
 * @since 0.2.0 added support for iterables
 *
 * @param iterable|\stdClass $collection The collection to iterate over.
 * @param array              $paths      Array paths to pick
 * @param mixed              $default    The default value that will be used if the specified path does not exist.
 *
 * @return array
 */
function pick($collection = [], array $paths = [], $default = null)
{
    return \__::reduce($paths, function ($results, $path) use ($collection, $default) {
        return \__::set($results, $path, \__::get($collection, $path, $default));
    }, \__::isObject($collection) && !($collection instanceof \ArrayAccess) ? new \stdClass() : []);
}
