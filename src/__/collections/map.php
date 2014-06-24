<?php

namespace collections;

/**
 * @collections @map
 */

function map(array $array = array(), \Closure $closure)
{
    foreach($array as $key => $value)
    {
        $array[$key] = $closure($value, $key);
    }

    return $array;
}