<?php

namespace collections;

/**
 * Returns an array having only keys present in the given path list.
 *
 * Values for missing keys values will be filled with provided default value.
 *
 ** __::pick(['a' => 1, 'b' => ['c' => 3, 'd' => 4]], ['a', 'b.d']);
 ** // → ['a' => 1, 'b' => ['d' => 4]]
 *
 * @param array|object $collection The collection to iterate over.
 * @param array $paths array paths to pick
 *
 * @return array
 */
function pick($collection = [], array $paths = [], $default = null)
{
    return \__::reduce($paths, function ($results, $path) use ($collection, $default) {
        return \__::set($results, $path, \__::get($collection, $path, $default));
    }, \__::isObject($collection) ? new \stdClass() : []);
}
