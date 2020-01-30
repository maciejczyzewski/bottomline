<?php

namespace collections;

/**
 * Inner function for collections::ease
 *
 * @internal
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
        } else {
            $map[$prefix . $index] = $value;
        }
    }
}

/**
 * Flattens a complex collection by mapping each ending leafs value to a key
 * consisting of all previous indexes.
 *
 * **Usage**
 *
 * ```php
 * __::ease([
 *     'foo' => ['bar' => 'ter'],
 *     'baz' => ['b', 'z']
 * ]);
 * ```
 *
 * **Result**
 *
 * ```
 * [
 *     'foo.bar' => 'ter',
 *     'baz.0' => 'b',
 *     'baz.1' => 'z'
 * ]
 * ```
 *
 * @since 0.2.0 added support for iterables
 *
 * @param iterable $collection array of values
 * @param string   $glue       glue between key path
 *
 * @return array flatten collection
 */
function ease($collection, $glue = '.')
{
    $map = [];
    _ease($map, $collection, $glue);

    return $map;
}
