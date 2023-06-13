<?php

namespace __\functions;

class _StringOps
{
    private static $hasMultibyteSupport;
    private $needsMultibyteSupport;

    public function __construct($string)
    {
        $this->needsMultibyteSupport = preg_match('/[^\x00-\x7F]/', $string) === 1;
        $this->assertMultibyte();
    }

    public function needsMultibyteSupport()
    {
        return $this->needsMultibyteSupport;
    }

    /**
     * @return string
     */
    public function smart_substr()
    {
        $args = func_get_args();
        $fxn = $this->needsMultibyteSupport ? 'mb_substr' : 'substr';

        if (!$this->needsMultibyteSupport) {
            array_pop($args);
        }

        return call_user_func_array($fxn, $args);
    }

    /**
     * @return int
     */
    public function smart_strlen()
    {
        $args = func_get_args();

        if ($this->needsMultibyteSupport) {
            call_user_func_array('mb_strlen', $args);
        }

        return strlen($args[0]);
    }

    /**
     * @return string
     */
    public function smart_strtolower()
    {
        $args = func_get_args();

        if ($this->needsMultibyteSupport) {
            return call_user_func_array('mb_strtolower', $args);
        }

        return strtolower($args[0]);
    }

    private function assertMultibyte()
    {
        if (!$this->needsMultibyteSupport) {
            return;
        }

        if ($this->hasMultibyteSupport()) {
            return;
        }

        throw new \RuntimeException('The `mbstring` extension is not available and is required.');
    }

    private function hasMultibyteSupport()
    {
        if (self::$hasMultibyteSupport === null) {
            self::$hasMultibyteSupport = extension_loaded('mbstring');
        }

        return self::$hasMultibyteSupport;
    }
}

/**
 * Create a web friendly URL slug from a string.
 *
 * Although supported, transliteration is discouraged because:
 *
 * 1. most web browsers support UTF-8 characters in URLs
 * 2. transliteration causes a loss of information
 *
 * **Usage**
 *
 * ```php
 * __::slug('Jakieś zdanie z dużą ilością obcych znaków!');
 * ```
 *
 * **Result**
 *
 * ```
 * 'jakies-zdanie-z-duza-iloscia-obcych-znakow'
 * ```
 *
 * @author    Sean Murphy <sean@iamseanmurphy.com>
 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
 * @license   http://creativecommons.org/publicdomain/zero/1.0/
 *
 * @param string $str     string to generate slug from
 * @param array  $options method options which includes: delimiter, limit, lowercase, replacements, transliterate
 *
 * @return string
 */
function slug($str, array $options = [])
{
    if (!is_string($str)) {
        throw new \InvalidArgumentException('The $str argument expends a string.');
    }

    $ops = new _StringOps($str);

    // Let's not waste resources if we don't need to do multibyte string processing
    if ($ops->needsMultibyteSupport()) {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        /** @var false|string $encodedString */
        $encodedString = \mb_convert_encoding($str, 'UTF-8', \mb_list_encodings());

        // PHP 8.1.0 has a bug where $encodedString can be an empty string, so
        // we only want to override `$str` if we have a good value.
        //   https://github.com/php/php-src/issues/7898
        if ($encodedString !== '' && $encodedString !== false) {
            $str = $encodedString;
        }
    }

    $defaults = [
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => [],
        'transliterate' => true
    ];

    // Merge options
    $options = array_merge($defaults, $options);

    // Make custom replacements
    if ($options['replacements']) {
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    }

    // Transliterate characters to ASCII
    if ($options['transliterate']) {
        $char_map = require(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'charmap.php');
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }

    // Replace non-alphanumeric characters with our delimiter
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

    // Remove duplicate delimiters
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', $options['delimiter'], $str);

    // Truncate slug to max. characters
    if ($options['limit']) {
        $str = $ops->smart_substr($str, 0, ($options['limit'] ?: $ops->smart_strlen($str, 'UTF-8')), 'UTF-8');
    }

    // Remove delimiter from ends
    $str = trim($str, $options['delimiter']);

    return $options['lowercase'] ? $ops->smart_strtolower($str, 'UTF-8') : $str;
}
