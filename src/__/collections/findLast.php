<?php

namespace collections;

/**
 * Return the last element that matches the given condition or `$returnValue` if no value is found (defaults to null).
 *
 * **Warning**: If you give this function an iterator, it will convert the iterator into an array and _then_ use that
 * array to find the last element; this will incur a performance hit.
 *
 * **Find by Primitive Condition in Array**
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
 * __::findLast($data, "defend");
 * ```
 *
 * **Result**
 *
 * ```
 * "defend"
 * ```
 *
 * **Find by Callback in an Array**
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
 * __::findLast($data, static function ($object, $key, $collection) {
 *    return $object->name === "defend";
 * });
 * ```
 *
 * **Result**
 *
 * ```
 * $data["sword"]
 * ```
 *
 * @since 0.2.1 added to bottomline
 *
 * @param iterable                        $collection  an array or iterable of values to look through
 * @param bool|\Closure|double|int|string $condition   condition to match using either a primitive value or a callback
 * @param mixed|null                      $returnValue the value to return if nothing matches
 *
 * @see find
 * @see findEntry
 * @see findLastEntry
 * @see findIndex
 * @see findLastIndex
 * @see where
 *
 * @return mixed|null The entity from the iterable. If no value is found, `$returnValue` is returned, which defaults to
 *     `null`.
 */
function findLast($collection, $condition, $returnValue = null)
{
    return \__::find(\__::reverseIterable($collection), $condition, $returnValue);
}
