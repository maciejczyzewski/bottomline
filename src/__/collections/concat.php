<?php

namespace collections;

/**
 * Combines and concat collections provided with each others.
 *
 * If the collections have common keys, then the values are appended in an array.
 * If numerical indexes are passed, then values are appended.
 *
 * For a recursive merge, see `__::merge()`.
 *
 * **Usage**
 *
 * ```php
 * __::concat(
 *     ['color' => ['favorite' => 'red', 5], 3],
 *     [10, 'color' => ['favorite' => 'green', 'blue']]
 * );
 * ```
 *
 * **Result**
 *
 * ```
 * [
 *     'color' => ['favorite' => ['green'], 5, 'blue'],
 *     3,
 *     10
 * ]
 * ```
 *
 * @param array|object $collection Collection to assign to.
 * @param array|object ...$_       N other collections to assign.
 *
 * @return array|object Assigned collection.
 *
 */
function concat($collection, $_)
{
    // TODO Alternative over casting to array: implement directly assign using
    // foreach (func_get_args() as $collectionN). (with object handling).
    // First collection determine output type (array vs. object).
    $isObject = \__::isObject($collection);
    // Cast args to array.
    $args = \__::map(func_get_args(), function ($arg) { return (array) $arg; });
    // PHP 5.6+ array_merge_recursive(...$args);
    $merged = call_user_func_array('array_merge', $args);;
    return $isObject ? (object) $merged : $merged;
}
