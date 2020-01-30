<?php

namespace functions;

/**
 * Truncate string based on count of words
 *
 * **Usage**
 *
 * ```php
 * $string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et mi orci.';
 *
 * __::truncate($string);
 * ```
 *
 * **Result**
 *
 * ```
 * 'Lorem ipsum dolor sit amet, ...'
 * ```
 *
 * @param string $text  text to truncate
 * @param int    $limit limit of words
 *
 * @return string
 */
function truncate($text, $limit)
{
    if (\str_word_count($text, 0) > $limit) {
        $words = \str_word_count($text, 2);
        $pos = \array_keys($words);
        $text = \mb_substr($text, 0, $pos[$limit], 'UTF-8') . '...';
    }

    return $text;
}
