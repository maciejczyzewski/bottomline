<?php

namespace collections;

/**
 * TODO Manage collections. Objects?
 * https://github.com/lodash/lodash/blob/master/reduce.js
 *
 * Reduces $collection to a value which is the $accumulator result of running each
 * element in $collection thru $iteratee, where each successive invocation is supplied
 * the return value of the previous.
 *
 * If $accumulator is not given, the first element of $collection is used as the
 * initial value.
 *
 * The $iteratee is invoked with four arguments:
 * ($accumulator, $value, $index|$key, $collection).
 *
 ** __::reduce([1, 2], function ($sum, $number) {
 **     return $sum + $number;
 ** }, 0);
 ** // >> 3
 *
 ** $a = [
 **     ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
 **     ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
 **     ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
 **     ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
 **     ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
 ** ];
 ** $iteratee = function ($accumulator, $value) {
 **     if (isset($accumulator[$value['city']]))
 **         $accumulator[$value['city']]++;
 **     else
 **         $accumulator[$value['city']] = 1;
 **     return $accumulator;
 ** };
 ** __::reduce($c, $iteratee, []);
 ** // >> [
 ** // >>    'Indianapolis' => 2,
 ** // >>    'Plainfield' => 1,
 ** // >>    'San Diego' => 1,
 ** // >>    'Mountain View' => 1,
 ** // >> ]
 *
 * @param array|object  $collection The collection to iterate over.
 * @param \Closure $iteratee The function invoked per iteration.
 * @param (*) [$accumulator] The initial value.
 *
 * @return (*): Returns the accumulated value.
 *
 */
function reduce($collection, \Closure $iteratee, $accumulator = NULL)
{
    if ($accumulator === NULL) {
        $accumulator = \__::first($collection);
    }
    foreach ($collection as $key => $value) {
        $accumulator = $iteratee($accumulator, $value, $key, $collection);
    }
    return $accumulator;
}
