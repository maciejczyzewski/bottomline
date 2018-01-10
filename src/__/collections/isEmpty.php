<?php

namespace collections;

/**
 * Check if value is an empty array or object.
 *
 * We consider any non enumerable as empty.
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
    // TODO Create and use our own __::size(). (Manage object, etc.).
    return (!\__::isArray($value) && !\__::isObject($value)) || count((array) $value) === 0;
}
