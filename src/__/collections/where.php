<?php

namespace collections;

/**
 * @collections @where
 */

function where(array $array = array(), array $key = array())
{
	$result = array();

	foreach($array as $k => $v)
	{
		$not = false;

		foreach($key as $j => $w)
		{
			if(\objects\isArray($w))
			{
				if(count(array_intersect($w, $v[$j])) == 0)
				{
					$not = true;
					break;					
				}
			}else{
				if($v[$j] != $w)
				{
					$not = true;
					break;
				}
			}
		}

		if( $not == false )
		{
			$result[] = $v;
		}
	}

	return $result;
}