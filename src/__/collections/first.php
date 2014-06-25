<?php

namespace collections;

/**
 * @collections @first
 */

function first($array, $take = null)
{
	if(!$take) return \array_shift($array);

	return \array_splice($array, 0, $take, true);
}