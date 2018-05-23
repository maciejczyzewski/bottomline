<?php

namespace arrays;

/**
 * Flattens a multidimensional array.
 *
 * If `$shallow` is set to TRUE, the array will only be flattened a single level.
 *
 * **Usage**
 *
 * ```php
 * __::flatten([1, 2, [3, [4]]], false);
 * ```
 *
 * **Result**
 *
 * ```
 * [1, 2, 3, 4]
 * ```
 *
 * @param array $array
 * @param bool $shallow
 *
 * @return array
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
