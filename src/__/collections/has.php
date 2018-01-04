<?php

namespace collections;

/**
 * Return true if $collection contains the requested $key.
 *
 * In constrast to isset(), __::has() returns true if the key exists but is null.
 *
 ** __::hasKeys(['foo' => 'bar', 'foz' => 'baz'], 'foo');
 ** // → true
 *
 ** __::hasKeys((object) ['foo' => 'bar', 'foz' => 'baz'], 'bar');
 ** // → false
 *
 * @param array $collection of key values pairs
 * @param string|integer $key key to look for
 *
 * @return boolean
 *
 */
function has($collection, $key)
{
    // TODO Support path lookup.
    $has = \__::isObject($collection) ? 'property_exists' : 'array_key_exists';
    $args = \__::isObject($collection) ? [$collection, $key] : [$key, $collection];

    return call_user_func_array($has, $args);
}
