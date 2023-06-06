<?php

namespace collections;

/**
 * Equivalent to JavaScript's `Array.prototype.some()` function, this method will
 * return true if any one item in the collection passes the callback truth test.
 *
 * This method will short-circuit on the first truthy callback result.
 *
 * **Usage**
 *
 * ```php
 * __::some([1, 3, 5, 10, 7, 9], static function ($item, $key, $collection) {
 *   return $item % 2 === 0;
 * });
 * ```
 *
 * **Result**
 *
 * ```
 * true
 * ```
 *
 * @since 0.2.4 added to library
 *
 * @param iterable|\stdClass $collection
 * @param \Closure|null      $callback
 *
 * @return bool
 */
function some($collection, \Closure $callback = null)
{
    if (is_null($callback)) {
        $callback = '\\__::identity';
    }

    $result = false; // By default, we will assume no items pass the truth test.

    \__::doForEach($collection, static function ($value, $key, $collection) use ($callback, &$result) {
        if ($callback($value, $key, $collection)) {
            $result = true; // A truthy result was found, so we can set the result to true.

            // Return false here so that we can exit the `doForEach()` loop.
            return false;
        }
    });

    return $result;
}
