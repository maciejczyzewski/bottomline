<?php

namespace objects;

/**
 * Check if the value is valid email.
 *
 * @param mixed $value
 *
 * @return bool
 */
function isEmail($value)
{
    return \filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
}
