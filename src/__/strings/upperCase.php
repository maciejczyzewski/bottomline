<?php

namespace strings;

/**
 * Converts string, as space separated words, to upper case.
 *
 * **Usage**
 *
 * ```php
 * __::upperCase('--foo-bar');
 * ```
 *
 * **Result**
 *
 * ```
 * 'FOO BAR'
 * ```
 *
 * @param string $input
 *
 * @return string
 */
function upperCase($input)
{
    $words = \__::words(\preg_replace("/['\x{2019}]/u", '', $input));

    return array_reduce(
        $words,
        function ($result, $word) use ($words) {
            $isFirst = \__::first($words) === $word;
            return $result . (!$isFirst ? ' ' : '') . \__::toUpper($word);
        },
        ''
    );
}
