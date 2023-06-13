<?php

namespace __\collections;

/**
 * Return the index or key of the _last_ element that matches the given condition or `$returnValue` if no value is found
 * (defaults to `-1`).
 *
 * **Warning**: If you give this function an iterator, it will convert the iterator into an array and _then_ use that
 * array to find the last element; this will incur a performance hit.
 *
 * **Find Index by Primitive Condition in a Numerically Indexed Array**
 *
 * ```php
 * $data = [
 *     "native",
 *     "pale",
 *     "explain",
 *     "persuade",
 *     "elastic",
 *     "explain",
 * ];
 *
 * __::findIndex($data, "explain")
 * ```
 *
 * **Result**
 *
 * ```
 * 5
 * ```
 *
 * **Find Index by Primitive Condition in an Associative Array**
 *
 * ```php
 * $data = [
 *     "table"    => "trick",
 *     "pen"      => "defend",
 *     "motherly" => "wide",
 *     "may"      => "needle",
 *     "sweat"    => "cake",
 *     "sword"    => "defend",
 * ];
 *
 * __::findLastIndex($data, "defend")
 * ```
 *
 * **Result**
 *
 * ```
 * "sword"
 * ```
 *
 * **Find by Callback Usage**
 *
 * ```php
 * $data = [
 *     "table"    => (object)["name" => "trick"],
 *     "pen"      => (object)["name" => "defend"],
 *     "motherly" => (object)["name" => "wide"],
 *     "may"      => (object)["name" => "needle"],
 *     "sweat"    => (object)["name" => "cake"],
 *     "sword"    => (object)["name" => "defend"],
 * ];
 *
 * __::findLastIndex($data, static function ($object, $key, $collection) {
 *     return $object->name === "defend";
 * })
 * ```
 *
 * **Result**
 *
 * ```
 * "sword"
 * ```
 *
 * @since 0.2.1 added to bottomline
 *
 * @param iterable                        $collection  an array or iterable of values to look through
 * @param bool|\Closure|double|int|string $condition   condition to match using either a primitive value or a callback
 * @param int|string                      $returnValue the value to return if nothing matches
 *
 * @see find
 * @see findEntry
 * @see findLastEntry
 * @see findIndex
 * @see findLast
 * @see where
 *
 * @return int|string The index where the respective value is found. When given a numerically
 *     indexed array, an int will be returned but when an associative array is given, a string will
 *     be returned.
 *     If no value is found, `$returnValue` is returned, which defaults to `-1`.
 */
function findLastIndex($collection, $condition, $returnValue = -1)
{
    return \__::findIndex(\__::reverseIterable($collection), $condition, $returnValue);
}
