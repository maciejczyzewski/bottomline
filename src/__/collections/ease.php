<?php

namespace collections;

/**
 * Flattens a complex collection by mapping each ending leafs value to a key consisting of all previous indexes.
 *
 * __::ease(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]);
 * // → '['foo.bar' => 'ter', 'baz.0' => 'b', , 'baz.1' => 'z']'
 *
 * @param array  $collection array of values
 * @param string $glue       glue between key path
 *
 * @return array flatten collection
 *
 */
function ease(array $collection, $glue = '.')
{
    $map = [];
    _ease($map, $collection, $glue);

    return $map;
}

/**
 * Inner function for collections::ease
 *
 * @param array  $map
 * @param array  $array
 * @param string $glue
 * @param string $prefix
 */
function _ease(&$map, $array, $glue, $prefix = '')
{
    foreach ($array as $index => $value) {
        if (\is_array($value)) {
            _ease($map, $value, $glue, $prefix . $index . $glue);
        } elseif (!\is_object($value)) {
            $map[$prefix . $index] = $value;
        }
    }
}