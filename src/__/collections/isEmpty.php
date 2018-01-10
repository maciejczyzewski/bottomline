<?php

namespace collections;

/**
 * Check if value is an empty array or object.
 *
 ** __::isEmpty([]);
 ** // → true
 *
 * @param $value The value to check for emptiness.
 *
 * @return boolean
 *
 */
function isEmpty($value)
{
    return count((array) $value) === 0;
}
