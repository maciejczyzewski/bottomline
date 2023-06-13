<?php

namespace arrays;

/**
 * Generate array of repeated values.
 *
 * **Usage**
 *
 * ```php
 * __::repeat('foo', 3);
 * ```
 *
 * **Result**
 *
 * ```
 * ['foo', 'foo', 'foo']
 * ```
 *
 * @param mixed  $object The object to repeat.
 * @param int    $times  How many times has to be repeated.
 *
 * @since 0.2.1 $object typehint was changed from `string` to `mixed`
 *
 * @return array Returns a new array of filled values.
 */
function repeat($object, $times)
{
    return array_fill(0, (int)$times, $object);
}
