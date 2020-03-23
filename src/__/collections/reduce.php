<?php

namespace collections;

/**
 * Reduces `$collection` to a value which is the $accumulator result of running
 * each element in `$collection` thru `$iteratee`, where each successive invocation
 * is supplied the return value of the previous.
 *
 * If `$accumulator` is not given, the first element of `$collection` is used as
 * the initial value.
 *
 * **Usage: Sum Example**
 *
 * ```php
 * __::reduce([1, 2], function ($accumulator, $value, $key, $collection) {
 *     return $accumulator + $value;
 * }, 0);
 * ```
 *
 * **Result**
 *
 * ```
 * 3
 * ```
 *
 * **Usage: Array Counter**
 *
 * ```php
 * $a = [
 *     ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
 *     ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
 *     ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
 *     ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
 *     ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
 * ];
 *
 * $iteratee = function ($accumulator, $value) {
 *     if (isset($accumulator[$value['city']]))
 *         $accumulator[$value['city']]++;
 *     else
 *         $accumulator[$value['city']] = 1;
 *     return $accumulator;
 * };
 *
 * __::reduce($c, $iteratee, []);
 * ```
 *
 * **Result**
 *
 * ```
 * [
 *    'Indianapolis' => 2,
 *    'Plainfield' => 1,
 *    'San Diego' => 1,
 *    'Mountain View' => 1,
 * ]
 * ```
 *
 * **Usage: Objects**
 *
 * ```php
 * $object = new \stdClass();
 * $object->a = 1;
 * $object->b = 2;
 * $object->c = 1;
 *
 * __::reduce($object, function ($result, $value, $key) {
 *     if (!isset($result[$value]))
 *         $result[$value] = [];
 *
 *     $result[$value][] = $key;
 *
 *     return $result;
 * }, [])
 * ```
 *
 * **Result**
 *
 * ```
 * [
 *     '1' => ['a', 'c'],
 *     '2' => ['b']
 * ]
 * ```
 *
 * @since 0.2.0 added support for iterables
 *
 * @param iterable|\stdClass    $collection  The collection to iterate over.
 * @param \Closure              $iteratee    The function invoked per iteration.
 * @param array|\stdClass|mixed $accumulator The initial value.
 *
 * @return array|\stdClass|mixed Returns the accumulated value.
 */
function reduce($collection, \Closure $iteratee, $accumulator = null)
{
    if ($accumulator === null) {
        $accumulator = \__::first($collection);
    }
    \__::doForEach(
        $collection,
        function ($value, $key, $collection) use (&$accumulator, $iteratee) {
            $accumulator = $iteratee($accumulator, $value, $key, $collection);
        }
    );
    return $accumulator;
}
