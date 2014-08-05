<?php

namespace arrays;

/**
 * Patches array by xpath.
 *
 * Arguments:
 * (Array): The array to patch.
 * (Array): List of new xpath-value pairs.
 *
 * Returns:
 * (Array): Returns patched array.
 *
 * @arrays @patch
 *
 ** __::patch(['addr' => ['country' => 'US', 'zip' => 12345]], ['/addr/country' => 'CA', '/addr/zip' => 54321]);
 ** // → ['addr' => ['country' => 'CA', 'zip' => 54321]]
 */

function patch($arr, $patches, $parent = '')
{
    foreach($arr as $key => $value)
    {
        $z = $parent . '/' . $key;

        if( isset($patches[$z]) )
        {
            $arr[ $key ] = $patches[$z];
            unset( $patches[$z] );

            if( !count($patches) )
            {
                break;
            }
        }

        if( is_array($value) )
        {
            $arr[ $key ] = patch($value, $patches, $z);
        }
    }

    return $arr;
}
