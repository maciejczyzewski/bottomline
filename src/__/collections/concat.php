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
 * @since 0.2.0 added support for iterables
 *
 * @param iterable|\stdClass $collection Collection to assign to.
 * @param iterable|\stdClass ...$_       N other collections to assign.
 *
 * @return array|\stdClass If the first argument given to this function is an
 *     `\stdClass`, an `\stdClass` will be returned. Otherwise, an array will be
 *     returned.
 */
function concat($collection, $_)
{
    $args = func_get_args();
    $areArrayish = \__::every($args, function ($arg) {
        return \__::isArray($arg) || $arg instanceof \stdClass;
    });

    if ($areArrayish) {
        $argsAsArrays = \__::map($args, function ($arg) {
            return (array)$arg;
        });
        $merged = call_user_func_array('array_merge', $argsAsArrays);

        return ($collection instanceof \stdClass) ? (object)$merged : $merged;
    }

    if ($collection instanceof \Iterator || $collection instanceof \IteratorAggregate) {
        $result = iterator_to_array(\__::getIterator($collection));
    } else {
        $result = (array)$collection;
    }

    foreach (\__::drop($args, 1) as $iterable) {
        foreach ($iterable as $key => $item) {
            if (\__::isNumber($key)) {
                $result[] = $item;
            } else {
                $result[$key] = $item;
            }
        }
    }

    return $result;
}
