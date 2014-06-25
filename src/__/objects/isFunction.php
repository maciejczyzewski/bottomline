<?php

namespace objects;

/**
 * @objects @isFunction
 */

function isFunction($value = null)
{
    return \is_callable($value);
}