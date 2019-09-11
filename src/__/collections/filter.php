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
 * @param array|iterable         $array   Array to filter
 * @param \Closure|null $closure Closure to filter the array
 *
 * @return array
 */
function filter($array, \Closure $closure = null)
{
    // For iterables.
    // https://secure.php.net/manual/en/language.types.iterable.php
    if (!\is_array($array)) {
        $values = [];
        foreach ($array as $value) {
            if ($closure) {
                if ($closure($value)) {
                    $values[] = $value;
                }
            } else if ($value) {
                $values[] = $value;
            }
        }
        return $values;
    }
    return \array_values(
        $closure ? \array_filter($array, $closure) : \array_filter($array)
    );
}
