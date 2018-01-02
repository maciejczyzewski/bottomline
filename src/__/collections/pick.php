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
 * @param array $array         assoc array of values
 * @param array $paths         array of paths to pick
 *
 * @return array
 */
function pick(array $array = [], array $paths = [], $default = null)
{
    $result = [];
    foreach ($paths as $path) {
        $result = \__::set($result, $path, \__::get($array, $path, $default));
    }
    return $result;
}
