<?php

namespace utilities;

/**
 * @utilities @isEmail
 */

function isEmail($value = null)
{
    return \filter_var($value, FILTER_VALIDATE_EMAIL) != false;
}
