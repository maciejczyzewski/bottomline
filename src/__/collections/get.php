<?php

namespace collections;

/**
 * get item of an array by index , aceepting nested index
 *
 ** __::get(['foo' => ['bar' => 'ter']], 'foo.bar');
 ** // → 'ter'
 *
 * @param array  $collection  array of values
 * @param string $key   key or index
 * @param null   $default default value to return if index not exist
 *
 * @return array|mixed|null
 *
 */
function get($collection = array(), $key = '', $default = null)
{
    if (\objects\isNull($key)) {
        return $collection;
    }

    if (!\objects\isObject($collection) && isset($collection[$key])) {
        return $collection[$key];
    }

    foreach (\explode('.', $key) as $segment) {
        if (\objects\isObject($collection)) {
            if (!isset($collection->{$segment})) {
                return $default instanceof \Closure ? $default() : $default;
            } else {
                $collection = $collection->$segment;
            }
        } else {
            if (!isset($collection[$segment])) {
                return $default instanceof \Closure ? $default() : $default;
            } else {
                $collection = $collection[$segment];
            }
        }
    }

    return $collection;
}
