<?php

namespace arrays;

/**
 * @arrays @append
 *
 ** __::append([1, 2, 3], 4);
 ** // → [1, 2, 3, 4]
 */

function append(array $array = array(), $value = null)
{
	$array[] = $value;

	return $array; 
}