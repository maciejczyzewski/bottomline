<?php

namespace strings;

/**
 * Converts string, as a whole, to lower case just like `strtoupper()`.
 *
 * **Usage**
 *
 * ```
 * __::toUpper('fooBar');
 * ```
 *
 * **Result**
 *
 * ```
 * 'FOOBAR'
 * ```
 *
 * @param string $input
 *
 * @return string
 */
function toUpper($input)
{
    return \strtoupper($input);
}
