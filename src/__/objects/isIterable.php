<?php

namespace objects;

/**
 * Check to see if something is iterable.
 *
 * @param mixed $value
 * @param bool  $strict Match PHP 7.1 behavior where and `\stdClass` is not iterable
 *
 * @return bool
 */
function isIterable($value, $strict = true)
{
    return (
        is_array($value) ||
        (!$strict && $value instanceof \stdClass) ||
        $value instanceof \Traversable
    );
}
