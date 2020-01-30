<?php

namespace collections;

/**
 * Returns true if `$input` contains all requested $keys. If `$strict` is `true`
 * it also checks if `$input` exclusively contains the given `$keys`.
 *
 * **Usage**
 *
 * ```php
 * __::hasKeys(['foo' => 'bar', 'foz' => 'baz'], ['foo', 'foz']);
 * ```
 *
 * **Result**
 *
 * ```
 * true
 * ```
 *
 * @param array|\stdClass $collection of key values pairs
 * @param array        $keys       collection of keys to look for
 * @param bool         $strict     to exclusively check
 *
 * @return bool
 */
function hasKeys($collection = [], array $keys = [], $strict = false)
{
    $keyCount = \count($keys);
    if ($strict && \count($collection) !== $keyCount) {
        return false;
    }
    return \__::every(
        \__::map($keys, function ($key) use ($collection) {
            return \__::has($collection, $key);
        }),
        function ($v) {
            return $v === true;
        }
    );
}
