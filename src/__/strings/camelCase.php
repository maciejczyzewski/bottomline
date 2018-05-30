<?php

namespace strings;

/**
 * Converts string to [camel case](https://en.wikipedia.org/wiki/CamelCase).
 *
 * **Usage**
 *
 * ```php
 * __::camelCase('Foo Bar');
 * ```
 *
 * **Result**
 *
 * ```
 * 'fooBar'
 * ```
 *
 * @param string $input
 *
 * @return string
 */
function camelCase($input)
{
    $words = \__::words(\preg_replace("/['\x{2019}]/u", '', $input));

    return array_reduce(
        $words,
        function ($result, $word) use ($words) {
            $isFirst = \__::first($words) === $word;
            $word = \__::toLower($word);
            return $result . (!$isFirst ? \__::capitalize($word) : $word);
        },
        ''
    );
}
