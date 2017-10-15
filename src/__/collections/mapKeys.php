<?php

namespace collections;

/**
 * Transforms the keys in a collection by running each key through the iterator
 *
 * @param array $array          array of values
 * @param \Closure $closure     closure to map the keys
 * @throws \Exception           if closure doesn't return a valid key that can be used in PHP array
 *
 * @return array
 */
function mapKeys(array $array, \Closure $closure = null)
{
    if (is_null($closure)) {
        $closure = '__::identity';
    }
    $resultArray = [];
    foreach ($array as $key => $value) {
        $newKey = call_user_func_array($closure, array($key, $value, $array));
        // key must be a number or string
        if (!is_numeric($newKey) && !is_string($newKey)) {
            throw new \Exception('closure must returns a number or string');
        }

        $resultArray[$newKey] = $value;
    }
    return $resultArray;
}
