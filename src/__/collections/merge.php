<?php

namespace collections;

/**
 * Recursively combines collections provided with each others. If the collections have
 * common keys, then the values are appended in an array. If numerical indexes
 * are passed, then values are appended.
 *
 * For a non-recursive merge, see __::assign.
 *
 ** __::merge(['color' => ['favorite' => 'red', 5]], [10, 'color' => ['favorite' => 'green', 'blue']]);
 ** // >> ['color' => ['favorite' => ['red', 'green'], 'blue'], 5, 10]
 *
 * @param array|object $collection1 First collection to merge.
 * @param array|object $... N other collections to merge.
 *
 * @return array|object Merged collection.
 *
 */
function merge()
{
    return \__::reduce(array_reverse(func_get_args()), function ($source, $result) {
        \__::doForEach($source, function ($sourceValue, $key) use(&$result) {
            if (!\__::has($result, $key)) {
                $result = \__::set($result, $key, $sourceValue);
            } else if(is_numeric($key)) {
                $result = \__::assign($result, [$sourceValue]);
            } else {
                $resultValue = \__::get($result, $key);
                $result = \__::set($result, $key, merge(
                    \__::isCollection($resultValue) ? $resultValue : (array) $resultValue,
                    \__::isCollection($sourceValue) ? $sourceValue : (array) $sourceValue
                ));
            }
        });
        return $result;
    }, []);
    // PHP 5.6+ array_merge_recursive(...func_get_args());
    // return call_user_func_array('array_merge_recursive', func_get_args());
}
