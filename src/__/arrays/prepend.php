<?php

namespace arrays;

function prepend(array $array = array(), $value = null)
{
	array_unshift($array, $value); 

	return $array;
}