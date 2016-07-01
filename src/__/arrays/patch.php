<?php

namespace arrays;

/**
 *  Patches array by xpath.
 *
 ** __::patch(['addr' => ['country' => 'US', 'zip' => 12345]], ['/addr/country' => 'CA', '/addr/zip' => 54321]);
 ** // → ['addr' => ['country' => 'CA', 'zip' => 54321]]
 *
 * @param array  $arr     The array to patch
 * @param  array $patches List of new xpath-value pairs
 * @param string $parent
 *
 * @return array Returns patched array
 *
 */
function patch($arr, $patches, $parent = '')
{
    foreach ($arr as $key => &$value) {
        $z = $parent . '/' . $key;

        if (isset($patches[$z])) {
            $value = $patches[$z];
            unset($patches[$z]);

            if (!count($patches)) {
                break;
            }
        }

        if (is_array($value)) {
            $value = patch($arr[$key], $patches, $z);
        }
    }

    return $arr;
}
