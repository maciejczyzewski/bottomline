<?php

namespace strings;

/**
 * Converts string to [start case](https://en.wikipedia.org/wiki/Letter_case#Stylistic_or_specialised_usage).
 *
 * **Usage**
 *
 * ```php
 * __::startCase('--foo-bar--');
 * ```
 *
 * **Result**
 *
 * ```
 * 'Foo Bar'
 * ```
 *
 * @param string $input
 *
 * @return string
 */
function startCase($input)
{
    $words = \__::words(\preg_replace("/['\x{2019}]/u", '', $input));

    return array_reduce(
        $words,
        function ($result, $word) use ($words) {
            $isFirst = \__::first($words) === $word;
            return $result . (!$isFirst ? ' ' : '') . \__::upperFirst($word);
        },
        ''
    );
}
