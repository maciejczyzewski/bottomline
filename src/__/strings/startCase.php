<?php

namespace strings;

/**
 * Converts string to start case. https://en.wikipedia.org/wiki/Letter_case#Stylistic_or_specialised_usage
 *
 * __::startCase('--foo-bar--');
 *      >> 'Foo Bar'
 *
 * @param string $input
 *
 * @return string
 *
 */
function startCase($input)
{
    $words = \__::words(\preg_replace("/[\x{2019}]/u", '', $input));
    echo('   ');
    print_r($words);
    echo('   ');

    return array_reduce(
        $words,
        function ($result, $word) use($words) {
            $isFirst = \__::first($words) === $word;
            print_r($word);
            echo('  - ');
            echo($isFirst ? ' true ' : ' false ');
            return $result . (!$isFirst ? ' ' : '') . \__::upperFirst($word);
        },
        ''
    );
}
