<?php

namespace objects;

/**
 * @objects @isEmail
 */

function isEmail($value = null)
{
    return \filter_var($value, FILTER_VALIDATE_EMAIL) != false;
}