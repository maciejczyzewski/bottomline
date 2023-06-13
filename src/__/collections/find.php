<?php

namespace __\collections;

/**
 * Return the first element that matches the given condition or `$returnValue` if no value is found (defaults to null).
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
 * __::find($data, "defend");
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
 * __::find($data, static function ($object, $key, $collection) {
 *    return $object->name === "defend";
 * });
 * ```
 *
 * **Result**
 *
 * ```
 * $data["pen"]
 * ```
 *
 * @since 0.2.1 added to bottomline
 *
 * @param array|iterable                  $collection  an array or iterable of values to look through
 * @param bool|\Closure|double|int|string $condition   condition to match using either a primitive value or a callback
 * @param mixed|null                      $returnValue the value to return if nothing matches
 *
 * @see findEntry
 * @see findLastEntry
 * @see findIndex
 * @see findLast
 * @see findLastIndex
 * @see where
 *
 * @return mixed|null The entity from the iterable. If no value is found, `$returnValue` is returned, which defaults to
 *     `null`.
 */
function find($collection, $condition, $returnValue = null)
{
    $entry = \__::findEntry($collection, $condition);

    if ($entry === null) {
        return $returnValue;
    }

    return $entry[1];
}
