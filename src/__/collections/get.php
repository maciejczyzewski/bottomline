<?php

namespace collections;

/**
 * Get item of an array or object by index, accepting path (nested index).
 *
 * If `$collection` is an object that implements the ArrayAccess interface, this
 * function will treat it as an array instead of accessing class properties.
 *
 * Use a period (`.`) in `$path` to go down a level in a multidimensional array.
 *
 * **Usage**
 *
 * ```php
 * __::get(['foo' => ['bar' => 'ter']], 'foo.bar');
 * ```
 *
 * **Result**
 *
 * ```
 * 'ter'
 * ```
 *
 * @param array|object $collection Array of values or object
 * @param string       $path       Array key or object attribute. Use a period
 *                                 for depicting a new level in a multidimensional
 *                                 array
 * @param mixed        $default    Default value to return if index not exist
 *
 * @return array|mixed|null
 */
function get($collection, $path, $default = null)
{
    // TODO Make the algorithm recursive.
    // TODO Factorize between object and array access (use a $getter function,
    // as the $setter in __::set()).
    if (\is_array($collection) && isset($collection[$path])) {
        return $collection[$path];
    }

    foreach (\__::split($path, \__::DOT_NOTATION_DELIMITER) as $segment) {
        if (\is_object($collection) && !($collection instanceof \ArrayAccess)) {
            if (isset($collection->{$segment})) {
                $collection = $collection->{$segment};
            } else {
                // TODO Remove Closure option: what is the point if it has no parameter:
                // it will always yield the same value? KISS.
                return $default && $default instanceof \Closure ? $default() : $default;
            }
        } else {
            if (isset($collection[$segment])) {
                $collection = $collection[$segment];
            } else {
                // TODO Same as above on Closure.
                return $default && $default instanceof \Closure ? $default() : $default;
            }
        }
    }

    return $collection;
}
