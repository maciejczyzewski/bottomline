<?php

namespace utilities;

/**
 * Readable wrapper for strpos()
 *
 * @param  string  $needle   Substring to search for
 * @param  string  $haystack String to search within
 * @param  integer $offset   Index of the $haystack we wish to start at
 *
 * @return bool              whether the
 */
function stringContains($needle, $haystack, $offset = 0)
{
    return strpos($haystack, $needle, $offset) !== false ? true : false;
}
