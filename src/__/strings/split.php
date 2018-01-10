<?php

namespace strings;

/**
 * Split a string by string.
 *
 * Based on explode, see http://php.net/manual/en/function.explode.php.
 *
 * __::split('a-b-c', '-', 2);
 *      >> ['a', 'b-c']
 *
 * @param string $input The string to split.
 * @param string $delimeter The boundary string.
 * @param [optional] $limit If limit is set and positive, the returned array
 * will contain a maximum of limit elements with the last element containing the
 * rest of string.
 * If the limit parameter is negative, all components except the last -limit are returned.
 * If the limit parameter is zero, then this is treated as 1.
 *
 * @return string
 *
 */
function split($input, $delimeter, $limit = PHP_INT_MAX)
{
    return explode($delimeter, $input, $limit);
}
