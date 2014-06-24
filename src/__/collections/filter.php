<?php

namespace collections;

/**
 * @collections @filter
 */

function filter(array $array = array(), \Closure $closure)
{
    if(!$closure)
    {   
        return \arrays\compact($array);
    }else{
        $result = array();

        foreach($array as $key => $value)
        {
            if(\call_user_func($closure, $value)){
                $result[] = $value;
            }
        }

        return $result;
    }
}