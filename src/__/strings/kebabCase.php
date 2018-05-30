<?php

namespace strings;

/**
 * Converts string to [kebab case](https://en.wikipedia.org/wiki/Letter_case#Special_case_styles).
 *
 * **Usage**
 *
 * ```php
 * __::kebabCase('Foo Bar');
 * ```
 *
 * **Result**
 *
 * ```
 * 'foo-bar'
 * ```
 *
 * @param string $input
 *
 * @return string
 */
function kebabCase($input)
{
    $words = \__::words(\preg_replace("/['\x{2019}]/u", '', $input));

    return array_reduce(
        $words,
        function ($result, $word) use ($words) {
            $isFirst = \__::first($words) === $word;
            return $result . (!$isFirst ? '-' : '') . \__::toLower($word);
        },
        ''
    );
}
