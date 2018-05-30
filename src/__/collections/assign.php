<?php

namespace collections;

/**
 * Combines and merge collections provided with each others.
 *
 * If the collections have common keys, then the last passed keys override the
 * previous. If numerical indexes are passed, then last passed indexes override
 * the previous.
 *
 * For a recursive merge, see `__::merge()`.
 *
 * **Usage**
 *
 * ```php
 * __::assign(
 *     [
 *         'color' => [
 *             'favorite' => 'red',
 *             5
 *         ],
 *         3
 *     ],
 *     [
 *         10,
 *         'color' => [
 *             'favorite' => 'green',
 *             'blue'
 *         ]
 *     ]
 * );
 * ```
 *
 * **Result**
 *
 * ```
 * [
 *     'color' => ['favorite' => 'green', 'blue'],
 *     10
 * ]
 * ```
 *
 * @param array|object ...$_ Collections to assign.
 *
 * @return array|object Assigned collection.
 */
function assign($_)
{
    return \__::reduceRight(func_get_args(), function ($source, $result) {
        \__::doForEach($source, function ($sourceValue, $key) use (&$result) {
            $result = \__::set($result, $key, $sourceValue);
        });
        return $result;
    }, []);
}
