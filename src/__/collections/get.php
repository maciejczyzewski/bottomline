<?php

namespace collections;

/**
 * get item of an array by index, accepting path (nested index).
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

    foreach (\__::split($path, '.') as $segment) {
        if (\is_object($collection) && !($collection instanceof \ArrayAccess)) {
            if (isset($collection->{$segment})) {
                $collection = $collection->{$segment};
            } else {
                // TODO Remove Closure option: what is the point if it has no parameter:
                // it will always yielf the same value? KISS.
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
