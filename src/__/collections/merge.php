<?php

namespace collections;

/**
 * Recursively combines and merge collections provided with each others.
 *
 * If the collections have common keys, then the last passed keys override the previous.
 * If numerical indexes are passed, then last passed indexes override the previous.
 *
 * For a non-recursive merge, see __::merge.
 *
 ** __::merge(['color' => ['favorite' => 'red', 'model' => 3, 5], 3], [10, 'color' => ['favorite' => 'green', 'blue']]);
 ** // >> ['color' => ['favorite' => 'green', 'model' => 3, 'blue'], 10]
 *
 * @param array|object $collection1 First collection to merge.
 * @param array|object $... N other collections to merge.
 *
 * @return array|object Concatened collection.
 *
 */
function merge()
{
    // TODO Use __::reduceRight()
    // (Requires to implement it. Itself may use __::doForEachRight() as base).
    return \__::reduce(array_reverse(func_get_args()), function ($source, $result) {
        \__::doForEach($source, function ($sourceValue, $key) use(&$result) {
            $value = $sourceValue;
            if (\__::isCollection($value)) {
                $value = merge(\__::get($result, $key), $sourceValue);
            }
            $result = \__::set($result, $key, $value);
        });
        return $result;
    }, []);
}
