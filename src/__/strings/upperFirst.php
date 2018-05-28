<?php

namespace strings;

/**
 * Converts the first character of string to upper case, like `ucfirst()`.
 *
 * **Usage**
 *
 * ```php
 * __::upperFirst('fred');
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
function upperFirst($input)
{
    return \ucfirst($input);
}
