<?php

namespace collections;

/**
 * Builds a multidimensional collection out of a hash map using the key as
 * indicator where to put the value.
 *
 * **Usage**
 *
 * ```php
 * __::unease(['foo.bar' => 'ter', 'baz.0' => 'b', , 'baz.1' => 'z']);
 * ```
 *
 * **Result**
 *
 * ```
 * ['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]
 * ```
 *
 * @since 0.2.0 added support for iterables
 *
 * @param iterable|\stdClass $collection Hash map of values
 * @param string             $separator  The glue used in the keys
 *
 * @return array
 */
function unease($collection, $separator = '.')
{
    $nonDefaultSeparator = $separator !== '.';
    $map = [];
    foreach ($collection as $key => $value) {
        $map = \__::set(
            $map,
            $nonDefaultSeparator ? \str_replace($separator, '.', $key) : $key,
            $value
        );
    }

    return $map;
}
