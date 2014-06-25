<?php

namespace arrays;

/**
 * @arrays @flatten
 */

function flatten(array $array = array()) {
    $result = array();

    array_walk_recursive($array, function($a) use (&$result) { 
    	$result[] = $a; 
    });
    
    return $result;
}