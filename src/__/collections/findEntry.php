<?php

namespace collections;

/**
 * Find the first key/value pair of a given element that matches the given condition or null if no match is found.
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
 * __::findEntry($data, "defend");
 * ```
 *
 * **Result**
 *
 * ```
 * ["pen", "defend"]
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
 * __::findEntry($data, static function ($object, $key, $collection) {
 *    return $object->name === "defend";
 * });
 * ```
 *
 * **Result**
 *
 * ```
 * ["pen", $data["pen"]]
 * ```
 *
 * @since 0.2.1 added to bottomline
 *
 * @param iterable                        $collection an array or iterable of values to look through
 * @param bool|\Closure|double|int|string $condition  condition to match using either a primitive value or a callback
 *
 * @see find
 * @see findLastEntry
 * @see findLastIndex
 * @see findIndex
 * @see findLast
 * @see where
 *
 * @return array|null An array with two values, the 0th index is the key and the 1st index is the value. Null is
 *     returned if no entries can be found in the given collection.
 */
function findEntry($collection, $condition)
{
    $comparison = is_callable($condition) ? $condition : static function ($value, $_key, $_arr) use ($condition) {
        return $value === $condition;
    };

    foreach ($collection as $key => $arrItem) {
        if ($comparison($arrItem, $key, $collection)) {
            return [$key, $arrItem];
        }
    }

    return null;
}
