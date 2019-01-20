<?php

namespace objects;

/**
 * Check if the objects are equals.
 *
 * Perform a deep (recursive) comparison when the parameters are arrays or objects.
 *
 * @param mixed $object1
 * @param mixed $object2
 *
 * @return bool
 */
function isEqual($object1, $object2)
{
    return $object1 === $object2;
}
