<?php

namespace arrays;

/**
 * Creates  an  array  with  all  falsey  values removed. The values
 * false, null, 0, "", undefined, and NaN are all falsey.
 *
 * Arguments:
 * (Array): The array to compact.
 *
 * Returns:
 * (Array): Returns a new array of filtered values.
 *
 * @arrays @compact
 *
 ** __::compact([0, 1, false, 2, '', 3]);
 ** // → [1, 2, 3]
 */

function compact(array $array = array())
{
    $result = array();
    
    foreach($array as $value)
    {
        if($value)
        {
        	$result[] = $value;
        }
    }

    return $result;
}

