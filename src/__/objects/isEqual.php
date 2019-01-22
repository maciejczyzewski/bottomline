<?php

namespace objects;

/**
 * Check if the objects are equals.
 *
 * Perform a deep (recursive) comparison when the parameters are arrays or objects.
 *
 * Note: This method supports comparing arrays, object objects, booleans, numbers, strings.
 * object objects are compared by their own enumerable properties (as returned by get_object_vars).
 *
 * **Usage**
 *
 * ```php
 * __::isEqual(['honfleur' => 1, 'rungis' => [2, 3]], ['honfleur' => 1, 'rungis' => [1, 2]]);
 * ```
 *
 * **Result**
 *
 * ```
 * false
 * ```
 *
 * @param mixed $object1
 * @param mixed $object2
 *
 * @return bool
 */
function isEqual($object1, $object2)
{
    if (\__::isCollection($object1)) {
        // Is not equal if number of keys differ.
        $object1Keys = \__::isObject($object1) ? array_keys(get_object_vars($object1)) : array_keys($object1);
        $object2Keys = \__::isObject($object2) ? array_keys(get_object_vars($object2)) : array_keys($object2);
        if (count($object1Keys) !== count($object2Keys)) {
            return false;
        }
        foreach ($object1 as $key1 => $value1) {
            if (!\__::has($object2, $key1) || !\__::isEqual($value1, \__::get($object2, $key1))) {
                return false;
            }
        }
        return true;
    }
    return $object1 === $object2;
}
