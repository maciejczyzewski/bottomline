<?php

namespace collections;

/**
 * Recursively combines and merge collections provided with each others.
 *
 * - If the collections have common keys, then the last passed keys override the previous.
 * - If numerical indexes are passed, then last passed indexes override the previous.
 *
 * For a non-recursive merge, see `__::assign()`.
 *
 * **Usage**
 *
 * ```php
 * __::merge(
 *     ['color' => ['favorite' => 'red', 'model' => 3, 5], 3],
 *     [10, 'color' => ['favorite' => 'green', 'blue']]
 * );
 * ```
 *
 * **Result**
 *
 * ```
 * ['color' => ['favorite' => 'green', 'model' => 3, 'blue'], 10]
 * ```
 *
 * @param iterable|\stdClass ...$_ Collections to merge.
 *
 * @return array|object Concatenated collection.
 */
function merge()
{
    return \__::reduceRight(func_get_args(), function ($source, $result) {
        \__::doForEach($source, function ($sourceValue, $key) use (&$result) {
            $value = $sourceValue;
            if (\__::isCollection($value)) {
                $value = merge(\__::get($result, $key), $sourceValue);
            }
            $result = \__::set($result, $key, $value);
        });
        return $result;
    }, []);
}
