<?php

namespace collections;

/**
 * Returns an array of values belonging to a given property of each item in a collection.
 *
 * @param array|object $collection array or object that can be converted to array
 * @param string       $property   property name
 *
 * @return array
 */
function pluck($collection, $property)
{
    $result = \array_map(function ($value) use ($property) {
        if (is_array($value) && isset($value[$property])) {
            return $value[$property];
        } elseif (\is_object($value) && isset($value->{$property})) {
            return $value->{$property};
        }

        foreach (\__::split($property, '.') as $segment) {
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

    return \array_values($result);
}
