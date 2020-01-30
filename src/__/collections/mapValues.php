<?php

namespace collections;

/**
 * @internal
 *
 * @param iterable $iterable
 * @param \Closure $closure
 *
 * @return \Generator
 */
function mapValuesIterable($iterable, $closure)
{
    foreach ($iterable as $key => $value) {
        yield $key => call_user_func_array($closure, [$value, $key, $iterable]);
    }
}

/**
 * Transforms the values in a collection by running each value through the iterator.
 *
 * **Usage**
 *
 * ```php
 * __::mapValues(['x' => 1], function($value, $key, $collection) {
 *     return "{$key}_{$value}";
 * });
 * ```
 *
 * **Result**
 *
 * ```
 * ['x' => 'x_1']
 * ```
 *
 * @since 0.2.0 added support for iterables
 *
 * @param iterable      $iterable Array of values
 * @param \Closure|null $closure  Closure to map the values
 *
 * @return array|\Generator
 */
function mapValues($iterable, \Closure $closure = null)
{
    if (is_null($closure)) {
        $closure = '__::identity';
    }

    if (is_array($iterable)) {
        return iterator_to_array(mapValuesIterable($iterable, $closure));
    }

    return mapValuesIterable($iterable, $closure);
}
