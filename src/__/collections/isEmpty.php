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
 * @since 0.2.0 added support for iterables
 *
 * @param iterable|\stdClass $value The value to check for emptiness.
 *
 * @return bool
 */
function isEmpty($value)
{
    $length = \__::size($value);

    if (\__::isNumber($length)) {
        return $length === 0;
    }

    try {
        $ittr = \__::getIterator($value);

        foreach ($ittr as $_) {
            return false;
        }
    } catch (\InvalidArgumentException $exception) {
    }

    return true;
}
