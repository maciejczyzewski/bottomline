<?php

namespace collections;

/**
 * Check if value is an empty array or object.
 *
 * We consider any non enumerable as empty.
 *
 * **Usage**
 *
 * ```php
 * __::isEmpty([]);
 * ```
 *
 * **Result**
 *
 * ```
 * true
 * ```
 *
 * @param array|object $value The value to check for emptiness.
 *
 * @return bool
 */
function isEmpty($value)
{
    // TODO Create and use our own __::size(). (Manage object, etc.).
    return (!\__::isArray($value) && !\__::isObject($value)) || count((array) $value) === 0;
}
