<?php

namespace arrays;

/**
 * @arrays @prepend
 *
 ** __::prepend([1, 2, 3], 4);
 ** // → [4, 1, 2, 3]
 */

function prepend(array $array = array(), $value = null)
{
	\array_unshift($array, $value); 

	return $array;
}