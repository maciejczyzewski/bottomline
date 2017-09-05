<?php

namespace strings;

// From https://github.com/lodash/lodash/blob/master/words.js
// TODO Support unicode words.

const asciiWords = '/[^\x00-\x2f\x3a-\x40\x5b-\x60\x7b-\x7f]+/';

/**
 * Splits string into an array of its words.
 *
 * __::words('fred, barney, & pebbles');
 *      >> ['fred', 'barney', 'pebbles']
 *
 * __::words('fred, barney, & pebbles', '/[^, ]+/');
 *      >> ['fred', 'barney', '&', 'pebbles']
 *
 * @param string $input
 * @param string $pattern : The pattern to match words.
 *
 * @return string
 *
 */
function words($input, $pattern = null)
{
    if ($pattern === null) {
        $pattern = asciiWords;
    }
    $r = preg_match_all($pattern, $input, $matches, PREG_PATTERN_ORDER);
    if ($r === false) {
        throw new RuntimeException('Regex exception');
    }

    return count($matches[0]) > 0 ? $matches[0] : [];
}
