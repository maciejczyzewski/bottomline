<?php

namespace collections;

/**
 * Return true if $collection contains the requested $key.
 *
 * In constrast to isset(), __::has() returns true if the key exists but is null.
 *
 ** __::has(['foo' => ['bar' => 'num'], 'foz' => 'baz'], 'foo.bar');
 ** // → true
 *
 ** __::hasKeys((object) ['foo' => 'bar', 'foz' => 'baz'], 'bar');
 ** // → false
 *
 * @param array|object $collection of key values pairs
 * @param string|integer $path Path to look for.
 *
 * @return boolean
 *
 */
function has($collection, $path)
{
    // TODO Factorize path mavigation/enumeration with set and get.
    $portions = \__::split($path, '.', 2);
    $key  = $portions[0];

    if (\count($portions) === 1) {
//         $has = \__::isObject($collection) ? 'property_exists' : 'array_key_exists';
//         $args = \__::isObject($collection) ? [$collection, $key] : [$key, $collection];
//         return call_user_func_array($has, $args);
        // We use a cast to array to handle the numeric keys for objects (workaround).
        // See: https://wiki.php.net/rfc/convert_numeric_keys_in_object_array_casts
        return array_key_exists($key, (array) $collection);
    }
    return has(\__::get($collection, $key), $portions[1]);
}
