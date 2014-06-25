<?php

namespace collections;

/**
 * @collections @pluck
 */

function pluck($collection = array(), $property = '')
{
    $plucked = \array_map(function ($value) use ($property) {
    	return \collections\get($value, $property);
    }, (array) $collection);

    if(\objects\isObject($collection)) $plucked = (object) $plucked;

    return $plucked;
}