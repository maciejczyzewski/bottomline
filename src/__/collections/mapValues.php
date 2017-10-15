<?php

namespace collections;

/**
 * Transforms the values in a collection by running each value through the iterator
 *
 * @param array $array          array of values
 * @param \Closure $closure     closure to map the values
 *
 * @return array
 */
function mapValues(array $array, \Closure $closure = null)
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
