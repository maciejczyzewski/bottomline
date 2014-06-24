<?php

namespace arrays;

/**
 * Fill an array.
 *
 * Arguments:
 * (Object): The object to repeat.
 * (Number): How many times has to be repeated.
 *
 * Returns:
 * (Array): Returns a new array of filled values.
 *
 * @arrays @repeat
 *
 ** __::repeat('foo', 3);
 ** // → ['foo', 'foo', 'foo']
 */

function repeat($object = '', $times = null)
{
    if($times == null)
    {
        return array();
    }else{
        return \array_fill(0, $times, $object);
    }
}