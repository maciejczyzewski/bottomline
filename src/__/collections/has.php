<?php

namespace collections;

/**
 * Return true if `$collection` contains the requested `$key`.
 *
 * In contrast to `isset()`, `__::has()` returns true if the key exists but is null.
 *
 * **Array Usage**
 *
 * ```php
 *  __::has(['foo' => ['bar' => 'num'], 'foz' => 'baz'], 'foo.bar');
 * ```
 *
 * **Result**
 *
 * ```
 * true
 * ```
 *
 * **Object Usage**
 *
 * ```php
 *  __::hasKeys((object) ['foo' => 'bar', 'foz' => 'baz'], 'bar');
 * ```
 *
 * **Result**
 *
 * ```
 * false
 * ```
 *
 * @param array|object $collection Array or object to search a key for
 * @param string|int   $path       Path to look for. Supports dot notation for traversing multiple levels.
 *
 * @return bool
 */
function has($collection, $path)
{
    $portions = \__::split($path, \__::DOT_NOTATION_DELIMITER, 2);
    $key = $portions[0];

    if (\count($portions) === 1) {
        // Calling array_key_exists on an ArrayAccess object will not call `offsetExists()`
        // See: http://php.net/manual/en/class.arrayaccess.php#104061
        if ($collection instanceof \ArrayAccess) {
            return $collection->offsetExists($key);
        }

        // We use a cast to array to handle the numeric keys for objects (workaround).
        // See: https://wiki.php.net/rfc/convert_numeric_keys_in_object_array_casts
        return array_key_exists($key, (array)$collection);
    }

    return has(\__::get($collection, $key), $portions[1]);
}
