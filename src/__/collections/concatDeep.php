<?php

namespace collections;

/**
 * Recursively combines and concat collections provided with each others.
 *
 * If the collections have common keys, then the values are appended in an array.
 * If numerical indexes are passed, then values are appended.
 *
 * For a non-recursive concat, see `__::concat()`.
 *
 * **Usage**
 *
 * ```php
 * __::concatDeep(
 *     ['color' => ['favorite' => 'red', 5], 3],
 *     [10, 'color' => ['favorite' => 'green', 'blue']]
 * );
 * ```
 *
 * **Result**
 *
 * ```
 * [
 *     'color' => [
 *         'favorite' => ['red', 'green'],
 *         5,
 *         'blue'
 *     ],
 *     3,
 *     10
 * ]
 * ```
 *
 * @since 0.2.0 iterable support was added
 *
 * @param iterable|\stdClass $collection First collection to concatDeep.
 * @param iterable|\stdClass ...$_       N other collections to concatDeep.
 *
 * @return array|\stdClass A concatenated collection. When the first argument given
 *     is an `\stdClass`, then resulting value will be an `\stdClass`. Otherwise,
 *     an array will always be returned.
 */
function concatDeep($collection, $_)
{
    return \__::reduceRight(func_get_args(), function ($source, $result) {
        if ($result instanceof \Iterator || $result instanceof \IteratorAggregate) {
            $result = iterator_to_array(\__::getIterator($result));
        }

        \__::doForEach($source, function ($sourceValue, $key) use (&$result) {
            if (!\__::has($result, $key)) {
                $result = \__::set($result, $key, $sourceValue);
            } elseif (is_numeric($key)) {
                $result = \__::concat($result, [$sourceValue]);
            } else {
                $resultValue = \__::get($result, $key);
                $result = \__::set($result, $key, concatDeep(
                    \__::isCollection($resultValue) ? $resultValue : (array)$resultValue,
                    \__::isCollection($sourceValue) ? $sourceValue : (array)$sourceValue
                ));
            }
        });
        return $result;
    }, []);
}
