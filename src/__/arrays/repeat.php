<?php

namespace arrays;

/**
 * generate array of repeated values
 *
 ** __::repeat('foo', 3);
 ** // → ['foo', 'foo', 'foo']
 *
 * @param string $object The object to repeat.
 * @param int    $times  How many times has to be repeated.
 *
 * @return array Returns a new array of filled values.
 *
 */
function repeat($object, $times)
{
    return \array_fill(0, (int)$times, $object);
}
