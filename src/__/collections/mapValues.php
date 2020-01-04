<?php

namespace collections;

/**
 * Transforms the values in a collection by running each value through the iterator.
 *
 * **Usage**
 *
 * ```php
 * __::mapValues(['x' => 1], function($value, $key, $collection) {
 *     return "{$key}_{$value}";
 * });
 * ```
 *
 * **Result**
 *
 * ```
 * ['x' => 'x_1']
 * ```
 *
 * @param array|iterable $array       Array of values
 * @param \Closure       $closure     Closure to map the values
 *
 * @return array
 */
function mapValues($array, \Closure $closure = null)
{
    if (is_null($closure)) {
        $closure = '__::identity';
    }
    $resultArray = [];
    foreach ($array as $key => $value) {
        $resultArray[$key] = call_user_func_array($closure, array($value, $key, $array));
    }
    return $resultArray;
}
