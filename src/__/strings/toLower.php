<?php

namespace strings;

/**
 * Converts string, as a whole, to lower case just like strtolower.
 *
 * __::toLower('fooBar');
 *      >> 'foobar'
 *
 * @param string $input
 *
 * @return string
 *
 */
function toLower($input)
{
    return \strtolower($input);
}
