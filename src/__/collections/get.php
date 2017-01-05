<?php

namespace collections;

/**
 * get item of an array by index , aceepting nested index
 *
 ** __::get(['foo' => ['bar' => 'ter']], 'foo.bar');
 ** // → 'ter'
 *
 * @param array|object   $collection array of values
 * @param string         $key        array key or object attribute
 * @param \Closure|mixed $default    default value to return if index not exist
 *
 * @return array|mixed|null
 *
 */
function get($collection, $key, $default = null)
{
    if (isset($collection[$key])) {
        return $collection[$key];
    }

    foreach (\explode('.', $key) as $segment) {
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
