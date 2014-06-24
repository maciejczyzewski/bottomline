<?php

namespace collections;

function pluck($collection = array(), $property = '')
{
    $plucked = array_map(function ($value) use ($property) {
    	return \arrays\get($value, $property);
    }, (array) $collection);

    if(is_object($collection)) $plucked = (object) $plucked;

    return $plucked;
}