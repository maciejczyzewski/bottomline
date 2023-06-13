<?php

namespace __\collections;

/**
 * Return the index or key of the _first_ element that matches the given condition or `$returnValue` if no value is
 * found (defaults to `-1`).
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
 * 2
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
 * __::findIndex($data, "defend")
 * ```
 *
 * **Result**
 *
 * ```
 * "pen"
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
 * __::findIndex($data, static function ($object, $key, $collection) {
 *     return $object->name === "defend";
 * })
 * ```
 *
 * **Result**
 *
 * ```
 * "pen"
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
 * @see findLast
 * @see findLastIndex
 * @see where
 *
 * @return int|string The index where the respective value is found. When given a numerically
 *     indexed array, an int will be returned but when an associative array is given, a string will
 *     be returned.
 *     If no value is found, `$returnValue` is returned, which defaults to `-1`.
 */
function findIndex($collection, $condition, $returnValue = -1)
{
    $entry = \__::findEntry($collection, $condition);

    if ($entry === null) {
        return $returnValue;
    }

    return $entry[0];
}
