<?php

namespace strings;

/**
 * Converts the first character of string to lower case, like lcfirst.
 *
 * __::lowerFirst('Fred');
 *      >> 'fred'
 *
 * @param string $input
 *
 * @return string
 *
 */
function lowerFirst($input)
{
    return \lcfirst($input);
}
