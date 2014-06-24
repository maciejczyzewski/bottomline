<?php

namespace arrays;

function append(array $array = array(), $value = null)
{
	$array[] = $value;

	return $array; 
}