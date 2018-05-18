<?php

namespace collections;

/**
 * get item of an array by index, accepting path (nested index).
 *
 * If $collection is an object that implementes the ArrayAccess interface, this
 * function will treat it as an array instead of accessing class properties.
 *
 ** __::get(['foo' => ['bar' => 'ter']], 'foo.bar');
 ** // → 'ter'
 *
 * @param array|object $collection array of values
 * @param string $path array key or object attribute
 * @param \Closure|mixed $default default value to return if index not exist
 *
 * @return array|mixed|null
 *
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
