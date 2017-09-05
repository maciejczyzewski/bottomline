<?php

namespace strings;

/**
 * Converts string, as a whole, to upper case just like strtoupper.
 *
 * __::toLower('fooBar');
 *      >> 'foobar'
 *
 * @param string $input
 *
 * @return string
 *
 */
function toUpper($input)
{
    return strtoupper($input);
}
