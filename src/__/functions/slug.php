<?php

namespace functions;

/**
 * Create a web friendly URL slug from a string.
 *
 * Although supported, transliteration is discouraged because
 *     1) most web browsers support UTF-8 characters in URLs
 *     2) transliteration causes a loss of information
 *
 * @author    Sean Murphy <sean@iamseanmurphy.com>
 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
 * @license   http://creativecommons.org/publicdomain/zero/1.0/
 *
 * @param string $str     string to generate slug from
 * @param array  $options method options which includes: delimiter, limit, lowercase, replacements, transliterate
 *
 * @return string
 *
 * @functions @slug
 */
function slug($str, array $options = [])
{
    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
    $str = \mb_convert_encoding((string)$str, 'UTF-8', \mb_list_encodings());

    $defaults = [
        'delimiter'     => '-',
        'limit'         => null,
        'lowercase'     => true,
        'replacements'  => [],
        'transliterate' => true
    ];

    // Merge options
    $options = \array_merge($defaults, $options);

    // Make custom replacements
    if ($options['replacements']) {
        $str = \preg_replace(\array_keys($options['replacements']), $options['replacements'], $str);
    }

    // Transliterate characters to ASCII
    if ($options['transliterate']) {
        $char_map = require(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'charmap.php');
        $str      = \str_replace(\array_keys($char_map), $char_map, $str);
    }

    // Replace non-alphanumeric characters with our delimiter
    $str = \preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

    // Remove duplicate delimiters
    $str = \preg_replace('/(' . \preg_quote($options['delimiter'], '/') . '){2,}/', $options['delimiter'], $str);

    // Truncate slug to max. characters
    if ($options['limit']) {
        $str = \mb_substr($str, 0, ($options['limit'] ?: \mb_strlen($str, 'UTF-8')), 'UTF-8');
    }

    // Remove delimiter from ends
    $str = \trim($str, $options['delimiter']);

    return $options['lowercase'] ? \mb_strtolower($str, 'UTF-8') : $str;
}
