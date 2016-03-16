<?php

namespace objects;

/**
 * check if give value is number or not
 *
 * @param null $value
 *
 * @return bool
 *
 */
function isNumber($value = null)
{
    return \is_numeric($value);
}
