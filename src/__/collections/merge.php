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
function merge($collection1, $collection2)
{
    // TODO Reimplement array_merge_recursive with support for objects.
    // __::merge() is an __:assign() with recursivity. Nop: index appending.
    // $isObject = \__::isObject($collection1);
    // return \__::reduce(func_get_args(), function ($merged, $collectionN) {
    //     \__::doForEach($collectionN, function ($value, $key) use(&$merged) {
    //         if (\__::has($merged, $key)) {
    //             // Append the value.
    //             if (!\__::isArray($merged[$key])) {
    //                 $merged[$key] = [$merged[$key]];
    //             }
    //             $merged[$key][] = $value;
    //             // TODO Where the recursivity?
    //         } else {
    //             $merged[$key] = $value;
    //             // $merged = \__::assign($merged, [$key => $value]);
    //         }
    //     });
    //     return $merged;
    //     // return \__::assign($merged, $collectionN);
    // }, []);
    // foreach (func_get_args() as $collectionN) {
    //
    // }
    // PHP 5.6+ array_merge_recursive(...func_get_args());
    return call_user_func_array('array_merge_recursive', func_get_args());
}
