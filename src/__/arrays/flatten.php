<?php

namespace arrays;

/**
 * @arrays @flatten
 */

// function flatten(array $array = array()) {
//   $result = array();
//   array_walk_recursive($array, function($a) use (&$result) {
//     $result[] = $a;
//   });
//   return $result;
// }


function baseFlatten(array $array, $shallow=false, $strict=true, $startIndex=0) {

  $output   = [];
  $idx      = 0;
  $length   = count($array);
  $value;

  foreach ($array as $index => $value) {
    if (is_array($value)) {

      if (!$shallow) {
        $value = baseFlatten($value, $shallow, $strict);
      }
      $j    = 0;
      $len  = count($value);
      // $length
      while ($j < $len) {
        $output[$idx++] = $value[$j++];
      }

    } else if (!$strict) {
      $output[$idx++] = $value;
    }
  }

  return $output;
}



function flatten($array, $shallow=false) {
  return baseFlatten($array, $shallow, false);
}
