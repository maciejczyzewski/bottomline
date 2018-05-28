<?php

namespace strings;

/**
 * Converts the first character of string to lower case, like lcfirst.
 *
 * **Usage**
 *
 * ```php
 * __::lowerFirst('Fred');
 * ```
 *
 * **Result**
 *
 * ```
 * 'fred'
 * ```
 *
 * @param string $input
 *
 * @return string
 */
function lowerFirst($input)
{
    return \lcfirst($input);
}
