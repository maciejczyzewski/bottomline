<?php

namespace objects;

/**
 * @objects @isNumber
 */

function isNumber($value = null)
{
    return \is_numeric($value);
}