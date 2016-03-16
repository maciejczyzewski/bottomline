<?php

namespace objects;

/**
 * check if give value is function or not
 *
 * @param null $value
 *
 * @return bool
 *
 */
function isFunction($value = null)
{
    return \is_callable($value);
}
