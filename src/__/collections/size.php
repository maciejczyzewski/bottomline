<?php

namespace collections;

/**
 * Get the size of an array or \Countable object. Or get the number of properties
 * an object has.
 *
 * **Usage**
 *
 * ```php
 * __::size(null)                    // false
 * __::size("true")                  // false; a string is not a collection
 * __::size([1, 2, 3])               // 3
 * __::size((object)[1, 2])          // 2
 * __::size(new ArrayIterator(5, 4)) // 2
 * ```
 *
 * @since 0.2.0
 *
 * @param mixed $value
 *
 * @return int|false False when the given object does not support getting its
 *     size.
 */
function size($value)
{
    if (\__::isArray($value) || $value instanceof \stdClass) {
        return count((array)$value);
    }

    if ($value instanceof \Countable) {
        return count($value);
    }

    try {
        $itr = \__::getIterator($value);

        return iterator_count($itr);
    } catch (\InvalidArgumentException $e) {
    }

    return false;
}
