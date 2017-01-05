<?php

namespace collections;

/**
 * Returns an array of values belonging to a given property of each item in a collection.
 *
 * @param array  $collection array
 * @param string $property   property name
 *
 * @return array
 */
function pluck(array $collection, $property)
{
    return \array_map(function ($value) use ($property) {
        if (isset($value[$property])) {
            return $value[$property];
        }

        foreach (\explode('.', $property) as $segment) {
            if (\is_object($value)) {
                if (isset($value->{$segment})) {
                    $value = $value->{$segment};
                } else {
                    return null;
                }
            } else {
                if (isset($value[$segment])) {
                    $value = $value[$segment];
                } else {
                    return null;
                }
            }
        }

        return $value;
    }, (array)$collection);
}
