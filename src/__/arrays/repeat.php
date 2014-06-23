<?php

namespace arrays;

function repeat($object = '', $times = null)
{
    if($times == null)
    {
        return array();
    }else{
        return \array_fill(0, $times, $object);
    }
}