<?php

namespace utilities;

/**
 * @utilities @isEmail
 * check if the value is valid email
 *
 * @param string $value
 *
 * @return bool
 *
 */
function isEmail($value = null)
{
    return \filter_var($value, FILTER_VALIDATE_EMAIL) != false;
}
