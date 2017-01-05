<?php

namespace objects;

/**
 * check if the value is valid email
 *
 * @param null $value
 *
 * @return bool
 *
 */
function isEmail($value)
{
    return \filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
}
