<?php

namespace collections;

/**
 * Returns the values in the collection that pass the truth test.
 *
 * When `$closure` is set to null, this function will automatically remove falsey
 * values. When `$closure` is given, then values where the closure returns false
 * will be removed.
 *
 * **Usage**
 *
 * ```php
 * $a = [
 *     ['name' => 'fred',   'age' => 32],
 *     ['name' => 'maciej', 'age' => 16]
 * ];
 *
 * __::filter($a, function($n) {
 *     return $n['age'] > 24;
 * });
 * ```
 *
 * **Result**
 *
 * ```
 * [['name' => 'fred', 'age' => 32]]
 * ```
 *
 * @param array         $array   Array to filter
 * @param \Closure|null $closure Closure to filter the array
 *
 * @return array
 */
function filter(array $array, \Closure $closure = null)
{
    return \array_values(
        $closure ? \array_filter($array, $closure) : \array_filter($array)
    );
}
