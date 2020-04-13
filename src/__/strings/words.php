<?php

namespace strings;

// From https://github.com/lodash/lodash/blob/master/words.js
// With a port of https://github.com/lodash/lodash/blob/master/.internal/unicodeWords.js
// to PHP.

/**
 * Splits string into an array of its words.
 *
 * **Usage: Default Behavior**
 *
 * ```php
 * __::words('fred, barney, & pebbles');
 * ```
 *
 * **Result**
 *
 * ```
 * ['fred', 'barney', 'pebbles']
 * ```
 *
 * Use a custom regex to define how words are split.
 *
 * **Usage: Custom Pattern**
 *
 * ```php
 * __::words('fred, barney, & pebbles', '/[^, ]+/');
 * ```
 *
 * **Result**
 *
 * ```
 * ['fred', 'barney', '&', 'pebbles']
 * ```
 *
 * @param string      $input   The string of words to split.
 * @param string|null $pattern The regex to match words.
 *
 * @return string[]
 */
function words($input, $pattern = null)
{
    /** Used to compose unicode character classes. */
    $rsAstralRange = '\x{e800}-\x{efff}';
    $rsComboMarksRange = '\x{0300}-\x{036f}';
    $reComboHalfMarksRange = '\x{fe20}-\x{fe2f}';
    $rsComboSymbolsRange = '\x{20d0}-\x{20ff}';
    $rsComboRange = $rsComboMarksRange . $reComboHalfMarksRange . $rsComboSymbolsRange;
    $rsDingbatRange = '\x{2700}-\x{27bf}';
    $rsLowerRange = 'a-z\\xdf-\\xf6\\xf8-\\xff';
    $rsMathOpRange = '\\xac\\xb1\\xd7\\xf7';
    $rsNonCharRange = '\\x00-\\x2f\\x3a-\\x40\\x5b-\\x60\\x7b-\\xbf';
    $rsPunctuationRange = '\x{2000}-\x{206f}';
    $rsSpaceRange = ' \\t\\x0b\\f\\xa0\x{feff}\\n\\r\x{2028}\x{2029}\x{1680}\x{180e}\x{2000}\x{2001}\x{2002}\x{2003}\x{2004}\x{2005}\x{2006}\x{2007}\x{2008}\x{2009}\x{200a}\x{202f}\x{205f}\x{3000}';
    $rsUpperRange = 'A-Z\\xc0-\\xd6\\xd8-\\xde';
    $rsVarRange = '\x{fe0e}\x{fe0f}';
    $rsBreakRange = $rsMathOpRange . $rsNonCharRange . $rsPunctuationRange . $rsSpaceRange;

    /** Used to compose unicode capture groups. */
    $rsApos = "['\x{2019}]";
    $rsBreak = '[' . $rsBreakRange . ']';
    $rsCombo = '[' . $rsComboRange . ']';
    $rsDigits = '\\d+';
    $rsDingbat = '[' . $rsDingbatRange . ']';
    $rsLower = '[' . $rsLowerRange . ']';
    $rsMisc = '[^' . $rsAstralRange . $rsBreakRange . $rsDigits . $rsDingbatRange . $rsLowerRange . $rsUpperRange . ']';
    $rsFitz = '\\x{e83c}[\x{effb}-\x{efff}]';
    $rsModifier = '(?:' . $rsCombo . '|' . $rsFitz . ')';
    $rsNonAstral = '[^' . $rsAstralRange . ']';
    $rsRegional = '(?:\x{e83c}[\x{ede6}-\x{edff}]){2}';
    $rsSurrPair = '[\x{e800}-\x{ebff}][\x{ec00}-\x{efff}]';
    $rsUpper = '[' . $rsUpperRange . ']';
    $rsZWJ = '\x{200d}';

    /** Used to compose unicode regexes. */
    $rsMiscLower = '(?:' . $rsLower . '|' . $rsMisc . ')';
    $rsMiscUpper = '(?:' . $rsUpper . '|' . $rsMisc . ')';
    $rsOptContrLower = '(?:' . $rsApos . '(?:d|ll|m|re|s|t|ve))?';
    $rsOptContrUpper = '(?:' . $rsApos . '(?:D|LL|M|RE|S|T|VE))?';
    $reOptMod = $rsModifier . '?';
    $rsOptVar = '[' . $rsVarRange . ']?';
    $rsOrdLower = '\\d*(?:(?:1st|2nd|3rd|(?![123])\\dth)\\b)';
    $rsOrdUpper = '\\d*(?:(?:1ST|2ND|3RD|(?![123])\\dTH)\\b)';

    $asciiWords = '/[^\x00-\x2f\x3a-\x40\x5b-\x60\x7b-\x7f]+/';

    $hasUnicodeWordRegex = '/[a-z][A-Z]|[A-Z]{2,}[a-z]|[0-9][a-zA-Z]|[a-zA-Z][0-9]|[^a-zA-Z0-9 ]/';

    $rsOptJoin = '(?:' . $rsZWJ . '(?:' . join('|', [$rsNonAstral, $rsRegional, $rsSurrPair]) . ')' . $rsOptVar . $reOptMod . ')*';
    $rsSeq = $rsOptVar . $reOptMod . $rsOptJoin;
    $rsEmoji = '(?:' . join('|', [$rsDingbat, $rsRegional, $rsSurrPair]) . ')' . $rsSeq;

    /**
     * Splits a Unicode `string` into an array of its words.
     *
     * @private
     * @param {string} The string to inspect.
     * @returns {Array} Returns the words of `string`.
     */
    $unicodeWords = '/' . join(
        '|',
        [
          $rsUpper . '?' . $rsLower . '+' . $rsOptContrLower . '(?=' . join('|', [$rsBreak, $rsUpper, '$']) . ')',
          $rsMiscUpper . '+' . $rsOptContrUpper . '(?=' . join('|', [$rsBreak, $rsUpper . $rsMiscLower, '$']) . ')',
          $rsUpper . '?' . $rsMiscLower . '+' . $rsOptContrLower,
          $rsUpper . '+' . $rsOptContrUpper,
          $rsOrdUpper,
          $rsOrdLower,
          $rsDigits,
          $rsEmoji
        ]
    ) . '/u';
    if ($pattern === null) {
        $hasUnicodeWord = \preg_match($hasUnicodeWordRegex, $input);
        $pattern = $hasUnicodeWord ? $unicodeWords : $asciiWords;
    }
    $r = \preg_match_all($pattern, $input, $matches, PREG_PATTERN_ORDER);
    if ($r === false) {
        throw new \RuntimeException('Regex exception');
    }

    return \count($matches[0]) > 0 ? $matches[0] : [];
}
