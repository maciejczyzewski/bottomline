<?php

namespace strings;

// From https://github.com/lodash/lodash/blob/master/words.js
// With a port of https://github.com/lodash/lodash/blob/master/.internal/unicodeWords.js
// to PHP.

/** Used to compose unicode character classes. */
const rsAstralRange = '\x{e800}-\x{efff}';
const rsComboMarksRange = '\x{0300}-\x{036f}';
const reComboHalfMarksRange = '\x{fe20}-\x{fe2f}';
const rsComboSymbolsRange = '\x{20d0}-\x{20ff}';
const rsComboRange = rsComboMarksRange . reComboHalfMarksRange . rsComboSymbolsRange;
const rsDingbatRange = '\x{2700}-\x{27bf}';
const rsLowerRange = 'a-z\\xdf-\\xf6\\xf8-\\xff';
const rsMathOpRange = '\\xac\\xb1\\xd7\\xf7';
const rsNonCharRange = '\\x00-\\x2f\\x3a-\\x40\\x5b-\\x60\\x7b-\\xbf';
const rsPunctuationRange = '\x{2000}-\x{206f}';
const rsSpaceRange = ' \\t\\x0b\\f\\xa0\x{feff}\\n\\r\x{2028}\x{2029}\x{1680}\x{180e}\x{2000}\x{2001}\x{2002}\x{2003}\x{2004}\x{2005}\x{2006}\x{2007}\x{2008}\x{2009}\x{200a}\x{202f}\x{205f}\x{3000}';
const rsUpperRange = 'A-Z\\xc0-\\xd6\\xd8-\\xde';
const rsVarRange = '\x{fe0e}\x{fe0f}';
const rsBreakRange = rsMathOpRange . rsNonCharRange . rsPunctuationRange . rsSpaceRange;

/** Used to compose unicode capture groups. */
const rsApos = "['\x{2019}]";
const rsBreak = '[' . rsBreakRange . ']';
const rsCombo = '[' . rsComboRange . ']';
const rsDigits = '\\d+';
const rsDingbat = '[' . rsDingbatRange . ']';
const rsLower = '[' . rsLowerRange . ']';
const rsMisc = '[^' . rsAstralRange . rsBreakRange . rsDigits . rsDingbatRange . rsLowerRange . rsUpperRange . ']';
const rsFitz = '\\x{e83c}[\x{effb}-\x{efff}]';
const rsModifier = '(?:' . rsCombo . '|' . rsFitz . ')';
const rsNonAstral = '[^' . rsAstralRange . ']';
const rsRegional = '(?:\x{e83c}[\x{ede6}-\x{edff}]){2}';
const rsSurrPair = '[\x{e800}-\x{ebff}][\x{ec00}-\x{efff}]';
const rsUpper = '[' . rsUpperRange . ']';
const rsZWJ = '\x{200d}';

/** Used to compose unicode regexes. */
const rsMiscLower = '(?:' . rsLower . '|' . rsMisc . ')';
const rsMiscUpper = '(?:' . rsUpper . '|' . rsMisc . ')';
const rsOptContrLower = '(?:' . rsApos . '(?:d|ll|m|re|s|t|ve))?';
const rsOptContrUpper = '(?:' . rsApos . '(?:D|LL|M|RE|S|T|VE))?';
const reOptMod = rsModifier . '?';
const rsOptVar = '[' . rsVarRange . ']?';
const rsOrdLower = '\\d*(?:(?:1st|2nd|3rd|(?![123])\\dth)\\b)';
const rsOrdUpper = '\\d*(?:(?:1ST|2ND|3RD|(?![123])\\dTH)\\b)';

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
    $rsOptJoin = '(?:' . rsZWJ . '(?:' . join('|', [rsNonAstral, rsRegional, rsSurrPair]) . ')' . rsOptVar . reOptMod . ')*';
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
    if ($pattern === null) {
        // var_dump($unicodeWords);
        $hasUnicodeWord = \preg_match(hasUnicodeWord, $input);
        $pattern = $hasUnicodeWord ? $unicodeWords : asciiWords;
    }
    $r = \preg_match_all($pattern, $input, $matches, PREG_PATTERN_ORDER);
    if ($r === false) {
        throw new RuntimeException('Regex exception');
    }

    return \count($matches[0]) > 0 ? $matches[0] : [];
}
