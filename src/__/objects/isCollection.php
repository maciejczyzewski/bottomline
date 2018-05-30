<?php

namespace objects;

/**
 * Check if the object is a collection.
 *
 * A collection is either an array or an object.
 *
 * @param mixed $object
 *
 * @return bool
 */
function isCollection($object)
{
    return \__::isArray($object) || \__::isObject($object);
}
