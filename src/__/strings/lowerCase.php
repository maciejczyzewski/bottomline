<?php

namespace strings;

/**
 * Converts string, as space separated words, to lower case.
 *
 * **Usage**
 *
 * ```php
 * __::lowerCase('--Foo-Bar--');
 * ```
 *
 * **Result**
 *
 * ```
 * 'foo bar'
 * ```
 *
 * @param string $input
 *
 * @return string
 */
function lowerCase($input)
{
    $words = \__::words(\preg_replace("/['\x{2019}]/u", '', $input));

    return array_reduce(
        $words,
        function ($result, $word) use ($words) {
            $isFirst = \__::first($words) === $word;
            return $result . (!$isFirst ? ' ' : '') . \__::toLower($word);
        },
        ''
    );
}
