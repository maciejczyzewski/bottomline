<?php

namespace strings;

/** Used to compose unicode character classes. */
const rsAstralRange = '\\ud800-\\udfff';
const rsComboMarksRange = '\\u0300-\\u036f';
const reComboHalfMarksRange = '\\ufe20-\\ufe2f';
const rsComboSymbolsRange = '\\u20d0-\\u20ff';
const rsComboRange = rsComboMarksRange . reComboHalfMarksRange . rsComboSymbolsRange;
const rsDingbatRange = '\\u2700-\\u27bf';
const rsLowerRange = 'a-z\\xdf-\\xf6\\xf8-\\xff';
const rsMathOpRange = '\\xac\\xb1\\xd7\\xf7';
const rsNonCharRange = '\\x00-\\x2f\\x3a-\\x40\\x5b-\\x60\\x7b-\\xbf';
const rsPunctuationRange = '\\u2000-\\u206f';
const rsSpaceRange = ' \\t\\x0b\\f\\xa0\\ufeff\\n\\r\\u2028\\u2029\\u1680\\u180e\\u2000\\u2001\\u2002\\u2003\\u2004\\u2005\\u2006\\u2007\\u2008\\u2009\\u200a\\u202f\\u205f\\u3000';
const rsUpperRange = 'A-Z\\xc0-\\xd6\\xd8-\\xde';
const rsVarRange = '\\ufe0e\\ufe0f';
const rsBreakRange = rsMathOpRange . rsNonCharRange . rsPunctuationRange . rsSpaceRange;

/** Used to compose unicode capture groups. */
const rsApos = "['\u2019]";
const rsBreak = '[' . rsBreakRange . ']';
const rsCombo = '[' . rsComboRange . ']';
const rsDigits = '\\d+';
const rsDingbat = '[' . rsDingbatRange . ']';
const rsLower = '[' . rsLowerRange . ']';
const rsMisc = '[^' . rsAstralRange . rsBreakRange . rsDigits . rsDingbatRange . rsLowerRange . rsUpperRange . ']';
const rsFitz = '\\ud83c[\\udffb-\\udfff]';
const rsModifier = '(?:' . rsCombo . '|' . rsFitz . ')';
const rsNonAstral = '[^' . rsAstralRange . ']';
const rsRegional = '(?:\\ud83c[\\udde6-\\uddff]){2}';
const rsSurrPair = '[\\ud800-\\udbff][\\udc00-\\udfff]';
const rsUpper = '[' . rsUpperRange . ']';
const rsZWJ = '\\u200d';

/** Used to compose unicode regexes. */
const rsMiscLower = '(?:' . rsLower . '|' . rsMisc . ')';
const rsMiscUpper = '(?:' . rsUpper . '|' . rsMisc . ')';
const rsOptContrLower = '(?:' . rsApos . '(?:d|ll|m|re|s|t|ve))?';
const rsOptContrUpper = '(?:' . rsApos . '(?:D|LL|M|RE|S|T|VE))?';
const reOptMod = rsModifier . '?';
const rsOptVar = '[' . rsVarRange . ']?';
// $rsOptJoin = '(?:' . rsZWJ . '?:' . join('|', [rsNonAstral, rsRegional, rsSurrPair]) . ')' . rsOptVar . reOptMod . ')*';
const rsOrdLower = '\\d*(?:(?:1st|2nd|3rd|(?![123])\\dth)\\b)';
const rsOrdUpper = '\\d*(?:(?:1ST|2ND|3RD|(?![123])\\dTH)\\b)';
// $rsSeq = rsOptVar . reOptMod . $rsOptJoin;
// $rsEmoji = '(?:' . join('|', [rsDingbat, rsRegional, rsSurrPair]) . ')' . $rsSeq;

// /**
//  * Splits a Unicode `string` into an array of its words.
//  *
//  * @private
//  * @param {string} The string to inspect.
//  * @returns {Array} Returns the words of `string`.
//  */
// $unicodeWords = '/' . join(
//     '|',
//     [
//       rsUpper . '?' . rsLower . '+' . rsOptContrLower . '(?=' . join('|', [rsBreak, rsUpper, '$']) . ')',
//       rsMiscUpper . '+' . rsOptContrUpper . '(?=' . join('|', [rsBreak, rsUpper . rsMiscLower, '$']) . ')',
//       rsUpper . '?' . rsMiscLower . '+' . rsOptContrLower,
//       rsUpper . '+' . rsOptContrUpper,
//       rsOrdUpper,
//       rsOrdLower,
//       rsDigits,
//       $rsEmoji
//     ]
// ) . '/u';

// From https://github.com/lodash/lodash/blob/master/words.js
// TODO Support unicode words.
// Port https://github.com/lodash/lodash/blob/master/.internal/unicodeWords.js
// to PHP.

const asciiWords = '/[^\x00-\x2f\x3a-\x40\x5b-\x60\x7b-\x7f]+/';

const hasUnicodeWord = '/[a-z][A-Z]|[A-Z]{2,}[a-z]|[0-9][a-zA-Z]|[a-zA-Z][0-9]|[^a-zA-Z0-9 ]/';

/**
 * Splits string into an array of its words.
 *
 * __::words('fred, barney, & pebbles');
 *      >> ['fred', 'barney', 'pebbles']
 *
 * __::words('fred, barney, & pebbles', '/[^, ]+/');
 *      >> ['fred', 'barney', '&', 'pebbles']
 *
 * @param string $input
 * @param string $pattern : The pattern to match words.
 *
 * @return string
 *
 */
function words($input, $pattern = null)
{
    // TODO Put up there.
    $rsOptJoin = '(?:' . rsZWJ . '?:' . join('|', [rsNonAstral, rsRegional, rsSurrPair]) . ')' . rsOptVar . reOptMod . ')*';
    $rsSeq = rsOptVar . reOptMod . $rsOptJoin;
    $rsEmoji = '(?:' . join('|', [rsDingbat, rsRegional, rsSurrPair]) . ')' . $rsSeq;

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
          rsUpper . '?' . rsLower . '+' . rsOptContrLower . '(?=' . join('|', [rsBreak, rsUpper, '$']) . ')',
          rsMiscUpper . '+' . rsOptContrUpper . '(?=' . join('|', [rsBreak, rsUpper . rsMiscLower, '$']) . ')',
          rsUpper . '?' . rsMiscLower . '+' . rsOptContrLower,
          rsUpper . '+' . rsOptContrUpper,
          rsOrdUpper,
          rsOrdLower,
          rsDigits,
          $rsEmoji
        ]
    ) . '/u';
    // TODO Put up there end.

    if ($pattern === null) {
        // var_dump($unicodeWords);
        $hasUnicodeWord = \preg_match(hasUnicodeWord, $input);
        $pattern = $hasUnicodeWord ? $unicodeWords : asciiWords;
        var_dump($input);
        var_dump($hasUnicodeWord === 1 ? '$hasUnicodeWord yes' : '$hasUnicodeWord no');
    }
    $r = \preg_match_all($pattern, $input, $matches, PREG_PATTERN_ORDER);
    if ($r === false) {
        throw new RuntimeException('Regex exception');
    }

    return \count($matches[0]) > 0 ? $matches[0] : [];
}
