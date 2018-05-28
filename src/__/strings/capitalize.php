<?php

namespace strings;

/**
 * Converts the first character of string to upper case and the remaining
 * to lower case.
 *
 * **Usage**
 *
 * ```php
 * __::capitalize('FRED');
 * ```
 *
 * **Result**
 *
 * ```
 * 'Fred'
 * ```
 *
 * @param string $input
 *
 * @return string
 */
function capitalize($input)
{
    return \__::upperFirst(\__::toLower($input));
}
