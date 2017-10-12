<?php

namespace collections;

/**
 * TODO Manage collections. Objects?
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
 * @param array|object  $collection The collection to iterate over.
 * @param \Closure $iteratee The function invoked per iteration.
 * @param (*) [$accumulator] The initial value.
 *
 * @return (*): Returns the accumulated value.
 *
 */
function reduce(array $collection, \Closure $iteratee, $accumulator = NULL)
{
    return \array_reduce($collection, $iteratee, $accumulator);
}
