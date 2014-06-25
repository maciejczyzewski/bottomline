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
    if(is_null($key)) return $collection;

    if(!is_object($collection) && isset($collection[$key]))
    {
    	return $collection[$key];
    }

    foreach(explode('.', $key) as $segment)
    {
      	if(is_object($collection))
      	{
        	if(!isset($collection->{$segment})) return $default instanceof Closure ? $default() : $default;
        	else $collection = $collection->$segment;
      	}else{
        	if(!isset($collection[$segment])) return $default instanceof Closure ? $default() : $default;
        	else $collection = $collection[$segment];
      	}
    }

    return $collection;
}