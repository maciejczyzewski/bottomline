<?php

namespace sequences;

include_once 'BottomlineWrapper.php';

/**
 * returns a wrapper instance, allows the value to be passed through multiple bottomline functions
 *
 * __::chain([0, 1, 2, 3, null])
 *   ->compact()
 *   ->prepend(4)
 *   ->value();
 * >> [4, 1, 2, 3]
 *
 * @param mixed $initialValue
 *
 * @return mixed
 *
 */
function chain($initialValue)
{
    return new \BottomlineWrapper($initialValue);
}
