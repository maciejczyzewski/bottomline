<?php

namespace functions;

/**
 * @functions @urlify
 *
 ** __::urlify("I love https://google.com");
 ** // → 'I love <a href="https://google.com">google.com</a>'
 */

function urlify($string)
{
	/* Proposed by:
	 * Søren Løvborg
	 * http://stackoverflow.com/users/136796/soren-lovborg
	 * http://stackoverflow.com/questions/17900004/turn-plain-text-urls-into-active-links-using-php/17900021#17900021
	 */

	$rexProtocol = '(https?://)?';
	$rexDomain   = '((?:[-a-zA-Z0-9]{1,63}\.)+[-a-zA-Z0-9]{2,63}|(?:[0-9]{1,3}\.){3}[0-9]{1,3})';
	$rexPort     = '(:[0-9]{1,5})?';
	$rexPath     = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
	$rexQuery    = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
	$rexFragment = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';

  return preg_replace_callback("&\\b$rexProtocol$rexDomain$rexPort$rexPath$rexQuery$rexFragment(?=[?.!,;:\"]?(\s|$))&", function ($match) {
	    $completeUrl = $match[1] ? $match[0] : "http://{$match[0]}";
	    return '<a href="' . $completeUrl . '">' . $match[2] . $match[3] . $match[4] . '</a>';
	}, htmlspecialchars($string));
}