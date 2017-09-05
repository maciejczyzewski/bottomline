<?php

namespace strings;

/**
 * Converts the first character of string to upper case, like ucfirst.
 *
 * __::upperFirst('fred');
 *      >> 'Fred'
 *
 * @param string $input
 *
 * @return string
 *
 */
function upperFirst($input)
{
    return \ucfirst($input);
}
