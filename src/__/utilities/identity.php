<?php

namespace utilities;

/**
 * Returns the first argument it receives.
 *
 * **Usage**
 *
 * ```php
 * __::identity('arg1', 'arg2');
 * ```
 *
 * **Result**
 *
 * ```
 * 'arg1'
 * ```
 *
 * @return mixed
 */
function identity()
{
    $args = func_get_args();
    return isset($args[0]) ? $args[0] : null;
}
