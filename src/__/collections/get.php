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
    if (\is_array($collection) && isset($collection[$path])) {
        return $collection[$path];
    }

    foreach (\explode('.', $path) as $segment) {
        if (\is_object($collection)) {
            if (isset($collection->{$segment})) {
                $collection = $collection->{$segment};
            } else {
                return $default && $default instanceof \Closure ? $default() : $default;
            }
        } else {
            if (isset($collection[$segment])) {
                $collection = $collection[$segment];
            } else {
                return $default && $default instanceof \Closure ? $default() : $default;
            }
        }
    }

    return $collection;
}
