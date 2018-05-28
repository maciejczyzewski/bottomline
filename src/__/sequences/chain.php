<?php

namespace sequences;

include_once 'BottomlineWrapper.php';

/**
 * Returns a wrapper instance, allows the value to be passed through multiple
 * bottomline functions.
 *
 * **Usage**
 *
 * ```php
 * __::chain([0, 1, 2, 3, null])
 *     ->compact()
 *     ->prepend(4)
 *     ->value()
 * ;
 * ```
 *
 * **Result**
 *
 * ```
 * [4, 1, 2, 3]
 * ```
 *
 * @param mixed $initialValue
 *
 * @return \__|\BottomlineWrapper|mixed
 */
function chain($initialValue)
{
    return new \BottomlineWrapper($initialValue);
}
