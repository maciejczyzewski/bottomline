<?php

namespace arrays;

/**
 * base flatten
 *
 * @param array $array
 * @param bool  $shallow
 * @param bool  $strict
 * @param int   $startIndex
 *
 * @return array
 *
 */
function baseFlatten(array $array, $shallow = false, $strict = true, $startIndex = 0)
{

    $output = [];
    $idx    = 0;

    foreach ($array as $index => $value) {
        if (is_array($value)) {

            if (!$shallow) {
                $value = baseFlatten($value, $shallow, $strict);
            }
            $j   = 0;
            $len = count($value);
            while ($j < $len) {
                $output[$idx++] = $value[$j++];
            }
        } else if (!$strict) {
            $output[$idx++] = $value;
        }
    }

    return $output;
}

/**
 * Flattens a multidimensional array. If you pass shallow, the array will only be flattened a single level.
 *
 * __::flatten([1, 2, [3, [4]]], [flatten]);
 *      >> [1, 2, 3, 4]
 *
 * @param      $array
 * @param bool $shallow
 *
 * @return array
 *
 */
function flatten($array, $shallow = false)
{
    return baseFlatten($array, $shallow, false);
}
