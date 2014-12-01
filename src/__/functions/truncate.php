<?php

namespace functions;

/**
 * @functions @truncate
 */

function truncate($text, $limit) {

  if (str_word_count($text, 0) > $limit) {
    $words  = str_word_count($text, 2);
    $pos    = array_keys($words);
    $text   = mb_substr($text, 0, $pos[$limit], 'UTF-8') . '...';
  }

  return $text;
}