<?php

namespace collections;

/**
 * Combines collections provided with each others. If the collections have
 * common keys, then the last passed keys override the previous. If numerical indexes
 * are passed, then values are appended.
 *
 * For a recursive merge, see __::merge.
 *
 ** __::assign(['color' => ['favorite' => 'red', 5]], [10, 'color' => ['favorite' => 'green', 'blue']]);
 ** // >> ['color' => ['favorite' => 'green', 'blue'], 5, 10]
 *
 * @param array|object $collection1 Collection to assign to.
 * @param array|object $... N other collections to assign.
 *
 * @return array|object Assigned collection.
 *
 */
function assign($collection1, $collection2)
{
    // TODO Alternative over casting to array: implement directly assign using
    // foreach (func_get_args() as $collectionN). (with object handling).
    // First collection determine output type (array vs. object).
    $isObject = \__::isObject($collection1);
    // Cast args to array.
    $args = \__::map(func_get_args(), function ($arg) { return (array) $arg; });
    // PHP 5.6+ array_merge_recursive(...$args);
    $merged = call_user_func_array('array_merge', $args);;
    return $isObject ? (object) $merged : $merged;
}
