<?php

namespace strings;

/**
 * Split a string by string.
 *
 * - If limit is set and positive, the returned array will contain a
 *   maximum of limit elements with the last element containing the rest
 *   of string.
 * - If the limit parameter is negative, all components except the last
 *   `-limit` are returned.
 * - If the limit parameter is zero, then this is treated as 1.
 *
 * **Usage**
 *
 * ```php
 * __::split('a-b-c', '-', 2);
 * ```
 *
 * **Result**
 *
 * ```
 * ['a', 'b-c']
 * ```
 *
 * @param string $input     The string to split.
 * @param string $delimiter The boundary string.
 * @param int    $limit
 *
 * @return string[]
 */
function split($input, $delimiter, $limit = PHP_INT_MAX)
{
    return explode($delimiter, $input, $limit);
}
