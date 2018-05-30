<?php

namespace strings;

/**
 * Converts string to [snake case](https://en.wikipedia.org/wiki/Snake_case).
 *
 * **Usage**
 *
 * ```php
 * __::snakeCase('Foo Bar');
 * ```
 *
 * **Result**
 *
 * ```
 * 'foo_bar'
 * ```
 *
 * @param string $input
 *
 * @return string
 */
function snakeCase($input)
{
    $words = \__::words(\preg_replace("/['\x{2019}]/u", '', $input));

    return array_reduce(
        $words,
        function ($result, $word) use ($words) {
            $isFirst = \__::first($words) === $word;
            return $result . (!$isFirst ? '_' : '') . \__::toLower($word);
        },
        ''
    );
}
