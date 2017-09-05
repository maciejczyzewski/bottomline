<?php

namespace strings;

/**
 * Converts string, as a whole, to lower case just like strtoupper.
 *
 * __::toUpper('fooBar');
 *      >> 'FOOBAR'
 *
 * @param string $input
 *
 * @return string
 *
 */
function toUpper($input)
{
    return \strtoupper($input);
}
