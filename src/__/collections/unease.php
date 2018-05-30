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
 * @param array  $collection Hash map of values
 * @param string $separator  The glue used in the keys
 *
 * @return array
 */
function unease(array $collection, $separator = '.')
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
};
