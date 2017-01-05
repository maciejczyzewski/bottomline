<?php

namespace arrays;

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
    $output = [];
    foreach ($array as $value) {
        if (is_array($value)) {
            if (!$shallow) {
                $value = flatten($value, $shallow);
            }
            foreach ($value as $valItem) {
                $output[] = $valItem;
            }
        } else {
            $output[] = $value;
        }
    }

    return $output;
}
