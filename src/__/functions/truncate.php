<?php

namespace functions;

/**
 * trunct string based on count of words
 *
 * @param string  $text  text to truncate
 * @param integer $limit limit of words
 *
 * @return string
 *
 */

function truncate($text, $limit = 40)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = mb_substr($text, 0, $pos[$limit], 'UTF-8') . '...';
    }

    return $text;
}
