<?php

namespace collections;

/**
 * @collections @get
 *
 ** __::get(['foo' => ['bar' => 'ter']], 'foo.bar');
 ** // → 'ter'
 */

function get($collection = array(), $key = '', $default = null)
{
    if(\objects\isNull($key)) return $collection;

    if(!\objects\isObject($collection) && isset($collection[$key]))
    {
    	return $collection[$key];
    }

    foreach(\explode('.', $key) as $segment)
    {
      	if(\objects\isObject($collection))
      	{
        	if(!isset($collection->{$segment})) return $default instanceof \Closure ? $default() : $default;
        	else $collection = $collection->$segment;
      	}else{
        	if(!isset($collection[$segment])) return $default instanceof \Closure ? $default() : $default;
        	else $collection = $collection[$segment];
      	}
    }

    return $collection;
}