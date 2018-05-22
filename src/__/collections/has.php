<?php

namespace collections;

/**
 * Return true if $collection contains the requested $key.
 *
 * In contrast to isset(), __::has() returns true if the key exists but is null.
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
    $portions = \__::split($path, \__::DOT_NOTATION_DELIMITER, 2);
    $key  = $portions[0];

    if (\count($portions) === 1) {
        // Calling array_key_exists on an ArrayAccess object will not call `offsetExists()`
        // See: http://php.net/manual/en/class.arrayaccess.php#104061
        if ($collection instanceof \ArrayAccess) {
            return $collection->offsetExists($key);
        }

        // We use a cast to array to handle the numeric keys for objects (workaround).
        // See: https://wiki.php.net/rfc/convert_numeric_keys_in_object_array_casts
        return array_key_exists($key, (array) $collection);
    }
    return has(\__::get($collection, $key), $portions[1]);
}
