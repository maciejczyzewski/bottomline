<?php

namespace collections;

/**
 * @internal
 *
 * @param $iterable
 * @param $closure
 *
 * @throws \Exception
 *
 * @return \Generator
 */
function mapKeysIterable($iterable, $closure)
{
    foreach ($iterable as $key => $value) {
        $newKey = call_user_func_array($closure, array($key, $value, $iterable));

        // key must be a number or string
        if (!is_numeric($newKey) && !is_string($newKey)) {
            throw new \Exception('closure must returns a number or string');
        }

        yield $newKey => $value;
    }
}

/**
 * Transforms the keys in a collection by running each key through the iterator.
 *
 * This function throws an `\Exception` when the closure doesn't return a valid
 * key that can be used in a PHP array.
 *
 * **Usage**
 *
 * ```php
 * __::mapKeys(['x' => 1], function($key, $value, $collection) {
 *     return "{$key}_{$value}";
 * });
 * ```
 *
 * **Result**
 *
 * ```
 * ['x_1' => 1]
 * ```
 *
 * @since 0.2.0 added support for iterables
 *
 * @param iterable      $iterable Array/iterable of values
 * @param \Closure|null $closure  Closure to map the keys
 *
 * @throws \Exception when closure doesn't return a valid key that can be used in PHP array
 *
 * @return array|\Generator
 */
function mapKeys($iterable, \Closure $closure = null)
{
    if (is_null($closure)) {
        $closure = '__::identity';
    }

    if (is_array($iterable)) {
        return iterator_to_array(mapKeysIterable($iterable, $closure));
    }

    return mapKeysIterable($iterable, $closure);
}
