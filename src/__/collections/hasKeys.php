<?php

namespace collections;

/**
 * Returns if $input contains all requested $keys. If $strict is true it also checks if $input exclusively contains the given $keys.
 *
 ** __::hasKeys(['foo' => 'bar', 'foz' => 'baz'], ['foo', 'foz']);
 ** // → true
 *
 * @param array $collection of key values pairs
 * @param array $keys collection of keys to look for
 * @param boolean $strict to exclusively check
 *
 * @return boolean
 *
 */
function hasKeys(array $collection = [], array $keys = [], $strict = false)
{
    $keysExist = (count(array_intersect($keys, array_keys($collection)))==count($keys));

    return (!$strict && $keysExist) || ($strict && $keysExist && count($keys) === count($collection));
}
